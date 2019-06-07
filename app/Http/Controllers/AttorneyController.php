<?php

namespace App\Http\Controllers;

use App\Mail\SendRequest;
use App\Mail\RequestReceived;
use App\Mail\RequestReceivedSemp;
use App\Mail\RequestProcessed;
use App\Mail\RequestProcessedSemp;
use ZanySoft\Zip\Zip;
use File;

use Illuminate\Support\Facades\Mail;

use App\Attorney;
use App\Form;
use App\Status;
use App\Attorney_forms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

// include(app_path().'/includes/makezip.php');

use CountryState;


class AttorneyController extends Controller
{

    public function __construct()
    {
      $this->list = '';
      $forms = new Form;
      $attorney = new Attorney;
      $status = new Status;
      $this->status = $status->retrieve_all_statuses();
      $this->forms = $forms->retrieve_all_forms();
      $this->forms_full = $forms->retrieve_all_forms_full();
      $this->disallowed_states = [
        'AA','AE','AP','AS','GU','MP','VI','UM',
      ];
      $banned = [
        'status_id' => '4'
      ];
      $this->banned = view('lists.banned', [
        'attorneys_banned' => $attorney->retrieve_all_attorneys($banned),
      ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (Auth::check()) {
        $pending = [
          'status_id' => '3'
        ];
        $form = view('lists.attorneys', [
          'attorneys_pending' => Attorney::retrieve_all_attorneys($pending),
          'state' => '',
        ]);
      } else {
        $form = view('forms.attorneys', [
          'semper' => SELF::generate_form_fields(SELF::semper_field_list()),
          'fields' => SELF::generate_form_fields(SELF::form_field_list()),
          'files' => SELF::generate_form_fields(SELF::form_file_input_field_list()),
          'forms' => $this->forms_full
        ]);
      }
      // var_dump($states = CountryState::getStates('US'));
      return view('main', [ 'form' => $form ] );
    }


    /**
     * Display a single attorney of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function single(Request $request)
    {
      if ($request->id) {
        $attorney = new Attorney;
        $id = [
          'id' => $request->id,
        ];

        $form = view('forms.attorney', [
          'request' => $request,
          'status' => SELF::generate_form_fields(SELF::status_field_list(), $attorney->retrieve_all_attorneys($id, true)),
          'semper' => SELF::generate_form_fields(SELF::semper_field_list(), $attorney->retrieve_all_attorneys($id, true)),
          'fields' => SELF::generate_form_fields(SELF::form_field_list(), $attorney->retrieve_all_attorneys($id, true)),
          'files' => SELF::generate_form_fields(SELF::form_file_input_field_list(), $attorney->retrieve_all_attorneys($id, true))
        ]);
      }

      return view('main', [ 'form' => $form ] );
    }

    /**
     * Update a single attorney.
     *
     * @return \Illuminate\Http\Response
     */
    public function single_update(Request $request)
    {
      $field_array = array_merge(SELF::form_field_list(), SELF::semper_field_list());
      Attorney::update_attorney_record($request, $field_array, SELF::status_field_list());

      $form_fields = SELF::form_file_input_field_list();
      foreach ($form_fields as $form_field => $form_data) {
        if ($request->$form_field) {
          $form_data = new Attorney_forms;
          $path = Storage::putFile('public', $request->$form_field, 'private');
          $form_data->path = $path;
          $form_data->form_id = $this->forms[$form_field];
          $form_data->attorney_id = $request->id;
          $form_data->save();
        }
      }

      if ($request->id) {
        $attorney = new Attorney;
        $id = [
          'id' => $request->id,
        ];

        $form = view('forms.attorney', [
          'request' => $request,
          'status' => SELF::generate_form_fields(SELF::status_field_list(), $attorney->retrieve_all_attorneys($id, true)),
          'semper' => SELF::generate_form_fields(SELF::semper_field_list(), $attorney->retrieve_all_attorneys($id, true)),
          'fields' => SELF::generate_form_fields(SELF::form_field_list(), $attorney->retrieve_all_attorneys($id, true)),
          'files' => SELF::generate_form_fields(SELF::form_file_input_field_list(), $attorney->retrieve_all_attorneys($id, true))
        ]);
      }
      if (($request->status_id == 1) || ($request->status_id == 2)) {
        Mail::to($request->email)->send(new RequestProcessed($request, SELF::form_field_list(), $request->status_id));
        Mail::to($request->semper_contact_email)->send(new RequestProcessedSemp($request, SELF::form_field_list(), $request->status_id));
      }

      return view('main', [ 'form' => $form ] );
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
      if ($request->state) {
        $attorney = new Attorney;
        $pending = [
          'state' => $request->state,
          'status_id' => '3'
        ];
        $approved = [
          'state' => $request->state,
          'status_id' => '2'
        ];

        $this->list = view('lists.attorneys', [
          'attorneys_approved' => $attorney->retrieve_all_attorneys($approved),
          'attorneys_pending' => $attorney->retrieve_all_attorneys($pending),
          'state' => $request->state,
        ]);
      }

      $states = view('forms.states', [ 'states' => CountryState::getStates('US'), 'current_state' => $request->state, 'disallowed_states' => $this->disallowed_states ]);

      // var_dump($states = CountryState::getStates('US'));
      return view('list', [ 'list' => $this->list, 'banned' => $this->banned, 'states' => $states ] );
    }

    /**
     * Display approval of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request)
    {
      if ($request->state) {
        $attorney = new Attorney;
        $this->list = view('lists.attorneys', [
          'attorneys' => $attorney->retrieve_all_attorneys('state', $request->state),
        ]);
      }

      $states = view('forms.states', [ 'states' => CountryState::getStates('US'), 'current_state' => $request->state, 'disallowed_states' => $this->disallowed_states]);

      // var_dump($states = CountryState::getStates('US'));
      return view('forms.approve', [ 'list' => $this->list, 'banned' => $this->banned, 'states' => $states ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form_fields = array_merge(SELF::form_field_list(), SELF::semper_field_list());
        $attorney = new Attorney;

        foreach ($form_fields as $form_field => $form_data) {
          $attorney->$form_field = $request->$form_field;
        }
        $attorney->status_id = 3;

        $attorney->save();

        $form_fields = SELF::form_file_input_field_list();
        foreach ($form_fields as $form_field => $form_data) {
          $form = new Attorney_forms;
          $path = Storage::putFile('public', $request->$form_field, 'public');
          $form->path = $path;
          $form->form_id = $this->forms[$form_field];
          $form->attorney_id = $attorney->id;
          $form->save();
        }

        Mail::to('attorneyapproval@semperhomeloans.com')->send(new SendRequest($attorney, SELF::form_field_list()));
        Mail::to($request->semper_contact_email)->send(new RequestReceivedSemp($attorney, SELF::semper_field_list()));
        Mail::to($request->email)->send(new RequestReceived($attorney, SELF::form_field_list()));

        return redirect()->back()->with('success', 'Your request has been submitted.');
        exit();

      }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attorney  $attorney
     * @return \Illuminate\Http\Response
     */
    public function show(Attorney $attorney)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attorney  $attorney
     * @return \Illuminate\Http\Response
     */
    public function edit(Attorney $attorney)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attorney  $attorney
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attorney $attorney)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attorney  $attorney
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Attorney $attorney)
    {
        $att = Attorney::find($request->id);
        $att->delete();
        return redirect($request->previous_url);
    }

    private function status_field_list()
    {

      $fields = [
        'status_id' => [
          'label' => 'Status',
          'type' => 'select',
          'values' => $this->status,
          'restrict_field' => true
        ],
      ];

      return $fields;
    }

    private function semper_field_list()
    {

      $fields = [
        'semper_contact' => [

        ],
        'semper_contact_email' => [
          'type' => 'email',
        ],
      ];

      return $fields;
    }


    private function form_field_list()
    {

      $fields = [
        'company_name' => [

        ],
        'company_contact_name' => [

        ],
        'address' => [

        ],
        'address_2' => [
          'required' => false,
        ],
        'city' => [

        ],
        'state' => [
          'type' => 'select',
          'values' => CountryState::getStates('US')
        ],
        'zip' => [
          'minlength' => 5,
        ],
        'email' => [
          'type' => 'email',
        ],
        'phone' => [
          'pattern' => '^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$'
        ],

      ];

      return $fields;
    }


    private function form_file_input_field_list()
    {

      $fields = [
        'e_o_insurance' => [
          'type' => 'file',
          'label' => 'E&O Insurance'
        ],
        'cpl' => [
          'type' => 'file',
          'label' => 'CPL'
        ],
        'wire_instructions' => [
          'type' => 'file',

        ],
        'mbfg_instructions' => [
          'type' => 'file',
          'label' => 'MBFG Instructions'
        ],
        'sample_cd' => [
          'type' => 'file',
          'label' => 'Sample CD'
        ],
        'business_license' => [
          'type' => 'file',
          'label' => 'Copy of Business License'
        ],
      ];

      return $fields;
    }

    public function download(Request $request)
    {
      File::delete('files.zip');
      $path = 'files.zip';
      $file = fopen($path, "w");
      $zip = Zip::open('files.zip');
      $zip->setMask(0644);
      $attorney_forms = Attorney_forms::retrieve_attorneys_forms($request->id);
      foreach ($attorney_forms as $key => $value) {
        $files[] = public_path(Storage::url('public/' . $value->path));
      }
      $zip->add( $files );
      $zip->close();
      $headers = [
        'Content-Type' => 'application/zip',
      ];
      return response()->download('files.zip', Attorney::retrieve_attorney_name($request->id).'.zip', $headers);
    }

    private function generate_form_fields($form_fields, $attorney = false)
    {
      if ($attorney) {
        $attorney_forms = new Attorney_forms;
        $forms = $attorney_forms->retrieve_attorneys_forms($attorney['id']);
      }
      $html = '';
      $attr = [];
      foreach ($form_fields as $field_key => $form_field) {
        if (
          (isset($form_field['restrict_field']) && $attorney) ||
          (!isset($form_field['restrict_field']))
        ) {
          $field_title = isset($form_field['label']) ? $form_field['label'] : ucwords(str_replace('_', ' ', $field_key));
          $html .= '<div class="form-group">';
            $html .= '<label for="' . $field_key . '">' . $field_title . '</label>';
            $field_type = isset($form_field['type']) ? $form_field['type'] : 'text';
            $file_required = ( isset($form_field['required']) && (!$form_field['required']) ) ? '' : 'required="required"';

            $field_min_length = isset($form_field['minlength']) ? 'minlength="' . $form_field['minlength'] . '"' : '';
            $field_pattern = isset($form_field['pattern']) ? 'pattern=' . $form_field['pattern'] : '';
            switch ($field_type) {

              case 'text':
              case 'email':
                $form_control = 'form-control';
                $html .= '<input class="' . $form_control . '" type="'. $field_type . '" name="' . $field_key . '" id="' . $field_key . '" value="' . ($attorney[$field_key] ?? $attorney[$field_key]) . '" ' . $file_required . ' ' . $field_min_length . $field_pattern . ' />';
              break;

              case 'file':
                $file_instance = false;
                $form_control = 'form-control';
                $form_control = 'form-control-file';
                if ($attorney) {


                  foreach ($forms as $key => $value) {
                    if ($value->form_id == $this->forms[$field_key]) {
                      $file_instance = $value->path;
                    }
                  }
                  $file_required = '';
                }
                // $file_required = '';
                if ($file_instance) {
                  $html .= '<a href="' . Storage::url($file_instance) . '">Download</a>';
                } else {
                  $html .= '<input class="' . $form_control . '" type="'. $field_type . '" name="' . $field_key . '" id="' . $field_key . '" value="' . ($attorney[$field_key] ?? $attorney[$field_key]) . '" ' . $file_required . ' accept="application/pdf" />';
                }
              break;

              case 'select':
                $html .= '<select class="form-control" name="' . $field_key . '" id="' . $field_key . '" />';
                  $html .= '<option value="">Please Select</option>';
                  foreach ($form_field['values'] as $key => $value) {
                    $html .= '<option value="' . $key . '" ' . ($key == $attorney[$field_key] ? 'selected' : '') . '>' . $value . '</option>';
                  }
                $html .= '</select>';
              break;

              default:

                break;
            }
          $html .= '</div>';
        }

      }


      return $html;
    }

    // private function attorney_select($type, $current_value)
    // {
    //   // code...
    // }

}
