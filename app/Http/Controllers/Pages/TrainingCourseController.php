<?php

namespace App\Http\Controllers\pages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelperController;
use App\Http\Requests\AnakPerusahaan;
use App\Http\Requests\TraningCourse;
use App\Http\Requests\ListItemDetail as RequestsListItemDetail;
use Carbon\Carbon;
use App\Models\TraningCourseModel;
use App\Models\TrainingCourseFilesModel;
use App\Models\TraningCourseDetailsModel;
use App\Models\ListItemDetail;
use App\Models\MasterTipeModel;
use App\Models\ListItemModel;
use App\Models\LogApp;
use App\Models\MenuModel;
use App\Models\SideListModel;
use App\Models\MtrainingCourseModel;
use App\Models\MsertifikasiModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManager;
use PDO;

class TrainingCourseController extends Controller
{
    public function traningCourse($id)
    {
        $data['menus'] = MenuModel::find(base64_decode($id));
        $data['title']      = 'Traning Kerja | Pages';
        $data['title_page'] = 'Pelatihan / Kursus | ' . $data['menus']->menu_name;
        $data['menu']       = MenuModel::all();
        

        return view('pages.traningcourse', $data);
    }

    public function getFilters() {
        $filters = DB::table('training_course_detail')
            ->join('m_training_course', 'm_training_course.id', '=', 'training_course_detail.id_m_traning_course') // Bergabung dengan tabel tipe_master
            ->join('m_sertifikasi', 'm_sertifikasi.id', '=', 'training_course_detail.id_m_sertifikasi') // Bergabung dengan tabel ifg_master_tipe
            ->select('training_course_detail.*', 'm_training_course.nama as category','m_sertifikasi.nama as cetificate_type') // Pilih kolom yang dibutuhkan
            ->distinct()
            ->get();
        return response()->json($filters);
    }
    
    public function getDataCourses(Request $request) {
        // Membuat query untuk tabel training_course_detail

        //dd($request->all());
        $query = DB::table('training_course_detail')
        ->join('m_training_course', 'm_training_course.id', '=', 'training_course_detail.id_m_traning_course') // Bergabung dengan tabel tipe_master
        ->join('m_sertifikasi', 'm_sertifikasi.id', '=', 'training_course_detail.id_m_sertifikasi') // Bergabung dengan tabel ifg_master_tipe
        ->select('training_course_detail.*', 'm_training_course.nama as category','m_sertifikasi.nama as cetificate_type'); // Pilih kolom yang dibutuhkan

        // Menerapkan filter berdasarkan parameter yang tersedia
        if ($request->has('traning_name') && $request->traning_name != '') {
            $query->where('training_course_detail.traning_name', 'LIKE', '%' . $request->traning_name . '%');
        }
       
        if ($request->category != '') {
            $query->where('m_training_course.nama', 'LIKE', '%' . $request->category . '%');
        }

        if ($request->cetificate_type != '') {
            $query->where('m_sertifikasi.nama', 'LIKE', '%' . $request->cetificate_type . '%');
        }
        
        if ($request->has('status') && $request->status != '') {
            $query->where('training_course_detail.status', 'LIKE', '%' . $request->status . '%');
        }
    
        // Mengambil hasil query
        $courses = $query->get();
        // Mengembalikan data dalam format JSON
        return response()->json($courses);
    }
    
    public function editTraningCourse($id)
    {
        $data['menus'] = MenuModel::find(15);
        $data['title']      = 'Traning Kerja | Pages';
        $data['title_page'] = 'Pelatihan / Kursus | ' . $data['menus']->menu_name;
        $data['content'] = base64_decode($id);
        $data['menu']       = MenuModel::all();
        $data['liscategory'] = MtrainingCourseModel::all();
        $data['listsertifikasi'] = MsertifikasiModel::all();
        
        $data['databyid'] = DB::table('training_course_detail')
            ->join('m_training_course', 'm_training_course.id', '=', 'training_course_detail.id_m_traning_course') // Bergabung dengan tabel tipe_master
            ->join('m_sertifikasi', 'm_sertifikasi.id', '=', 'training_course_detail.id_m_sertifikasi') // Bergabung dengan tabel ifg_master_tipe
            ->select('training_course_detail.*', 'm_training_course.nama as category','m_sertifikasi.nama as cetificate_type')
            ->where('training_course_detail.id',base64_decode($id))->first(); // Pilih kolom yang dibutuhkan
        $dt_list_item =  TraningCourseDetailsModel::where('id',base64_decode($id))->first();
        $data['registration_schedule']  = Carbon::parse($dt_list_item->registration_schedule)->format('d/m/Y');
        $data['startdate']  = Carbon::parse($dt_list_item->startdate)->format('d/m/Y');
        $data['enddate']  = Carbon::parse($dt_list_item->enddate)->format('d/m/Y');

        $data['iddtl']=base64_decode($id);



        return view('pages.traningcourse_edit', $data);
    }


    public function ViewsStoretraningcourse($id)
    {
        $data['menus'] = MenuModel::find(15);
        $data['title']      = 'Traning Kerja | Pages';
        $data['title_page'] = 'Pelatihan / Kursus | ' . $data['menus']->menu_name;
        $data['content'] = base64_decode($id);
        $data['menu']       = MenuModel::all();

        $data['liscategory'] = MtrainingCourseModel::all();
        $data['listsertifikasi'] = MsertifikasiModel::all();

      
        
        return view('pages.traningcourse_store', $data);
    }



   

    public function storeCourseEndpoint(Request $req)
    {
       
        try {
           
           
             $registration_schedule = Carbon::createFromFormat('m/d/Y', $req->registration_schedule)->format('Y-m-d');
             $startdate = Carbon::createFromFormat('m/d/Y', $req->startdate)->format('Y-m-d');
             $enddate = Carbon::createFromFormat('m/d/Y', $req->enddate)->format('Y-m-d');

            $listItem = new TraningCourseDetailsModel();
            $listItem->traning_name                 = $req->traning_name;
            $listItem->id_m_traning_course          = $req->category;
            $listItem->id_m_sertifikasi             = $req->cetificate_type;
            $listItem->training_duration            = $req->training_duration;
            $listItem->requirements                 = (new HelperController)->scriptStripper( $req->requirements ?? '-');
            $listItem->registration_schedule        = $registration_schedule;
            $listItem->startdate                    = $startdate;
            $listItem->enddate                      = $enddate;
            $listItem->registrationfee               = $req->salarytraining;
            $listItem->training_material            = (new HelperController)->scriptStripper( $req->training_material ?? '-');
            $listItem->facility                     = (new HelperController)->scriptStripper( $req->facility ?? '-');
            $listItem->typeonlineoffile             = $req->typeonlineoffile;
            $listItem->location                     = $req->location;
            $listItem->link_pendaftaran             = $req->link_pendaftaran;
            $listItem->file                         = $req->filename;
            $listItem->status                       = $req->status;
            $listItem->insert_by                    = session()->get('id');
            $listItem->updated_by                   = session()->get('id');
            $listItem->updated_by_ip                = $req->ip();
            
            
            $listItem->save();
            if (!is_null($req->item_file)) {
                for ($index = 0; $index < count($req->item_file); $index++) {
                    $filenamepenulis = null;
            
                    if (isset($req->item_file[$index])) {
                        $file = $req->file('item_file')[$index];
                        $ext = $file->extension();
                        $filenamepenulis = uniqid() . '.' . $file->getClientOriginalExtension();
            
                        
                            $manager = new ImageManager();
                            $img = $manager->make($file->getPathname());
            
                            if ($ext == 'png' || $ext == 'PNG') {
                                $filenamepenulis = uniqid() . '.webp';
                            }
                            $img->save(public_path('storage') . '/'  . $filenamepenulis, 80);
            
                            if (env('PLATFORM_NAME') !== 'windows') {
                                // SFTP
                                Storage::disk('sftp')->put('/' . $filenamepenulis, $img->encode());
                            } else {
                                Storage::disk('windows_uploads')->put('/' . $filenamepenulis, $img->encode());
                            }
                        }
                       
                        $datapenulis = new TrainingCourseFilesModel();
                        $datapenulis->id_course_training_dtl = $listItem->id;
                        $datapenulis->nama = $filenamepenulis;
                        $datapenulis->insert_by = session()->get('id');
                        $datapenulis->updated_by = session()->get('id');
                        $datapenulis->updated_by_ip = $req->ip();
                        $datapenulis->save();
                   
                }
            }
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil disimpan'
            ];
        } catch (ModelNotFoundException $e) {
            $response = [
                'status' => 'failed',
                'message' => "Terjadi Kesalahan pada sistem : " . $e,
            ];
        }
        $status = $req->status;

        $statusText = ($status == 1) ? 'publish' :
              (($status == 2) ? 'pending' :
              (($status == 3) ? 'preview' : 'unknown'));
        
        $log_app = new LogApp();
        $log_app->method = $req->method();
        $log_app->request = "Create Traning Course '{$statusText}'";
        $log_app->response =  json_encode($response);
        $log_app->pages = 'Traning';
        $log_app->user_id = session()->get('id');
        $log_app->ip_address = $req->ip();
        $log_app->save();
        return json_encode($response);
    }


    public function updateCourseEndpoint(Request $req)
    {
       
        try {
           
         
             $registration_schedule = Carbon::createFromFormat('m/d/Y', $req->registration_schedule)->format('Y-m-d');
             $startdate = Carbon::createFromFormat('m/d/Y', $req->startdate)->format('Y-m-d');
             $enddate = Carbon::createFromFormat('m/d/Y', $req->enddate)->format('Y-m-d');
             
            $listItem = new TraningCourseDetailsModel();
            $listItem = TraningCourseDetailsModel::find($req->iddtl);
            $listItem->traning_name                 = $req->traning_name;
            $listItem->id_m_traning_course          = $req->category;
            $listItem->id_m_sertifikasi             = $req->cetificate_type;
            $listItem->training_duration            = $req->training_duration;
            $listItem->requirements                 = (new HelperController)->scriptStripper( $req->requirements ?? '-');
            $listItem->registration_schedule        = $registration_schedule;
            $listItem->startdate                    = $startdate;
            $listItem->enddate                      = $enddate;
            $listItem->registrationfee               = $req->salarytraining;
            $listItem->training_material            = (new HelperController)->scriptStripper( $req->training_material ?? '-');
            $listItem->facility                     = (new HelperController)->scriptStripper( $req->facility ?? '-');
            $listItem->typeonlineoffile             = $req->typeonlineoffile;
            $listItem->location                     = $req->location;
            $listItem->link_pendaftaran             = $req->link_pendaftaran;
            $listItem->file                         = $req->filename;
            $listItem->status                       = $req->status;
            $listItem->insert_by                    = session()->get('id');
            $listItem->updated_by                   = session()->get('id');
            $listItem->updated_by_ip                = $req->ip();
            
            
            $listItem->save();
            if (!is_null($req->item_file)) {
                for ($index = 0; $index < count($req->item_file); $index++) {
                    $filenamepenulis = null;
            
                    if (isset($req->item_file[$index])) {
                        $file = $req->file('item_file')[$index];
                        $ext = $file->extension();
                        $filenamepenulis = uniqid() . '.' . $file->getClientOriginalExtension();
            
                        
                            $manager = new ImageManager();
                            $img = $manager->make($file->getPathname());
            
                            if ($ext == 'png' || $ext == 'PNG') {
                                $filenamepenulis = uniqid() . '.webp';
                            }
                            $img->save(public_path('storage') . '/'  . $filenamepenulis, 80);
            
                            if (env('PLATFORM_NAME') !== 'windows') {
                                // SFTP
                                Storage::disk('sftp')->put('/' . $filenamepenulis, $img->encode());
                            } else {
                                Storage::disk('windows_uploads')->put('/' . $filenamepenulis, $img->encode());
                            }
                        }
                       
                        $datapenulis = new TrainingCourseFilesModel();
                        $datapenulis->id_course_training_dtl = $req->iddtl;
                        $datapenulis->nama = $filenamepenulis;
                        $datapenulis->insert_by = session()->get('id');
                        $datapenulis->updated_by = session()->get('id');
                        $datapenulis->updated_by_ip = $req->ip();
                        $datapenulis->save();
                   
                }
            }
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil disimpan'
            ];
        } catch (ModelNotFoundException $e) {
            $response = [
                'status' => 'failed',
                'message' => "Terjadi Kesalahan pada sistem : " . $e,
            ];
        }
        $status = $req->status;

        $statusText = ($status == 1) ? 'publish' :
              (($status == 2) ? 'pending' :
              (($status == 3) ? 'preview' : 'unknown'));
        
        $log_app = new LogApp();
        $log_app->method = $req->method();
        $log_app->request = "Create Traning Course '{$statusText}'";
        $log_app->response =  json_encode($response);
        $log_app->pages = 'Traning';
        $log_app->user_id = session()->get('id');
        $log_app->ip_address = $req->ip();
        $log_app->save();
        return json_encode($response);
    }


    public function editTraningCourseDetail($id)
    {
        try {
                $dt_list_item =  TraningCourseDetailsModel::find($id);
                $output = View::make("components.traning-course-component")
                    ->with("dt_item", $dt_list_item)
                    ->with("route", route('update-traning-course-detail'))
                    ->with("formId", "traning-course-edit")
                    ->with("formMethod", "PUT")
                    ->render();

                $response = [
                    'status' => 'success',
                    'output'  => $output,
                    'message' => 'Berhasil Parsing',
                ];
                return json_encode($response);
        } catch (Exception $e) {
            $response = [
                'status' => 'failed',
                'message' => "Terjadi Kesalahan pada sistem.",
            ];
        }
        return json_encode($response);
    }


    public function updateTraningCourseDetail(Request $req)
    {
       

        try {
            
            $listItem = TraningCourseDetailsModel::find($req->upt_id);
            $listItem->traning_name            = $req->traning_name;
            $listItem->traning_name_en         = $req->traning_name;
            $listItem->cetificate_type         = $req->cetificate_type;
            $listItem->cetificate_type_en      = $req->cetificate_type_en;
            $listItem->startdate     = $req->startdate;
            $listItem->enddate     = $req->enddate;
            $listItem->training_duration       = $req->training_duration;
            $listItem->requirements       = (new HelperController)->scriptStripper( $req->requirements ?? '-');
            $listItem->requirements_en    = (new HelperController)->scriptStripper( $req->requirements_en ?? '-');
            $listItem->training_material                = $req->training_material;
            $listItem->training_material_en             = $req->training_material_en;
            $listItem->facility                = $req->facility;
            $listItem->facility_en             = $req->facility_en;
          
            $listItem->insert_by = session()->get('id');
            $listItem->updated_by = session()->get('id');
            $listItem->updated_by_ip = $req->ip();
            if (!is_null($req->file('item_file'))) {
                $manager                = new ImageManager();
                $ext                    =  $req->file('item_file')->extension();
                $img                    = $manager->make($req->file('item_file')->getPathname());
                $listItem->file         = uniqid() . '.' . $req->file('item_file')->getClientOriginalExtension();

                if ($ext == 'png' || $ext == 'PNG') {
                    $listItem->file = uniqid() . '.' . 'webp';
                }

                $img->save(public_path('storage') . '/'  . $listItem->file, 80);

                if (env('PLATFORM_NAME') !== 'windows') {
                    //SFTP
                    Storage::disk('sftp')->put('/' . $listItem->file, $img);
                } else {
                    Storage::disk('windows_uploads')->put('/' . $listItem->file, $img);
                }
            }

            $listItem->save();
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil disimpan'
            ];
        } catch (ModelNotFoundException $e) {
            $response = [
                'status' => 'failed',
                'message' => "Terjadi Kesalahan pada sistem : " . $e,
            ];
        }

        $log_app = new LogApp();
        $log_app->method = $req->method();
        $log_app->request =  "Update Traning Course";
        $log_app->response =  json_encode($response);
        $log_app->pages = 'Traning';
        $log_app->user_id = session()->get('id');
        $log_app->ip_address = $req->ip();
        $log_app->save();
        return json_encode($response);
    }
}
