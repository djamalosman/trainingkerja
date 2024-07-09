<?php

namespace App\Http\Controllers\pages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelperController;
use App\Http\Requests\AnakPerusahaan;
use App\Http\Requests\TraningCourse;
use App\Http\Requests\ListItemDetail as RequestsListItemDetail;
use Carbon\Carbon;
use App\Models\JobVacancyModel;
use App\Models\JobVacancyDetailModel;
use App\Models\JobVacancyFilesModel;

use App\Models\ListItemDetail;
use App\Models\MasterTipeModel;
use App\Models\ListItemModel;
use App\Models\LogApp;
use App\Models\MenuModel;
use App\Models\SideListModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManager;
use PDO;

class JobVacancyController extends Controller
{
    public function jobVacancy($id)
    {
        $data['menus'] = MenuModel::find(base64_decode($id));
        $data['title']      = 'Job Vacancy | Pages';
        $data['title_page'] = 'Job Vacancy | ' . $data['menus']->menu_name;
        $data['menu']       = MenuModel::all();
   
        return view('pages.jobvacancy', $data);
    }

    public function getDropdownJob() {
        $filters = DB::table('job_vacancy_detail')
            ->join('m_job_vacancy', 'm_job_vacancy.id', '=', 'job_vacancy_detail.id_job_m_vacancy') // Bergabung dengan tabel tipe_master
            ->select('job_vacancy_detail.*', 'm_job_vacancy.nama as category') // Pilih kolom yang dibutuhkan
            
            ->distinct()
            ->get();
        return response()->json($filters);
    }
    
    public function getDataJobFilter(Request $request) {
        // Membuat query untuk tabel training_course_detail
        //dd($request->all());
        $query = DB::table('job_vacancy_detail')
        ->join('m_job_vacancy', 'm_job_vacancy.id', '=', 'job_vacancy_detail.id_job_m_vacancy') // Bergabung dengan tabel tipe_master
        ->select('job_vacancy_detail.*', 'm_job_vacancy.nama as category'); // Pilih kolom yang dibutuhkan); // Pilih kolom yang dibutuhkan
        
        // Menerapkan filter berdasarkan parameter yang tersedia
        if ($request->has('vacancy_name') && $request->vacancy_name != '') {
            $query->where('job_vacancy_detail.vacancy_name', 'LIKE', '%' . $request->vacancy_name . '%');
        }
        if ($request->category != '') {
            $query->where('m_job_vacancy.nama', 'LIKE', '%' . $request->category . '%');
        }
    
        // if ($request->has('location') && $request->location != '') {
        //     $query->whereDate('job_vacancy_detail.location', '=', $request->location);
        // }
    
        // if ($request->has('status_vacancy') && $request->status_vacancy != '') {
        //     $query->where('job_vacancy_detail.status_vacancy', 'LIKE', '%' . $request->status_vacancy . '%');
        // }
    
        // if ($request->has('posted_date') && $request->posted_date != '') {
        //     $query->where('job_vacancy_detail.posted_date', 'LIKE', '%' . $request->posted_date . '%');
        // }
        // if ($request->has('close_date') && $request->close_date != '') {
        //     $query->where('job_vacancy_detail.close_date', 'LIKE', '%' . $request->close_date . '%');
        // }
        
        // if ($request->has('vacancy_level') && $request->vacancy_level != '') {
        //     $query->where('job_vacancy_detail.vacancy_level', 'LIKE', '%' . $request->vacancy_level . '%');
        // }
        // Mengambil hasil query
        $courses = $query->get();
        // Mengembalikan data dalam format JSON
        return response()->json($courses);
    }

    public function getViewStoreJobvacancy($id)
    {
        $data['menus'] = MenuModel::find(base64_decode($id));
        $data['title']      = 'Job Vacancy | Pages';
        $data['title_page'] = 'Job Vacancy | ' . $data['menus']->menu_name;
        $data['menu']       = MenuModel::all();
        $data['liscategory'] = JobVacancyModel::all();
        return view('pages.jobvacancy_store', $data);
    }

    

   

    public function editJobVacancy($id)
    {
        $data['menus'] = MenuModel::find(34);
        $data['title']      = 'Lowongan Kerja';
        $data['title_page'] = 'Pelatihan / Kursus | ' . $data['menus']->menu_name;
        $data['content'] = base64_decode($id);
        $data['menu']       = MenuModel::all();
     
        $data['liscategory'] = JobVacancyModel::all();
        $data['databyid'] = DB::table('job_vacancy_detail')
            ->join('m_job_vacancy', 'm_job_vacancy.id', '=', 'job_vacancy_detail.id_job_m_vacancy') // Bergabung dengan tabel tipe_master
            ->select('job_vacancy_detail.*', 'm_job_vacancy.nama as category')
            ->where('job_vacancy_detail.id',base64_decode($id))->first();

        $data['getImage'] = DB::table('job_vacancy_detail')
            ->join('m_job_vacancy_file', 'm_job_vacancy_file.id_job_vacancy_dtl', '=', 'job_vacancy_detail.id') // Bergabung dengan tabel tipe_master
            ->select('m_job_vacancy_file.nama as namaImage' )
            ->where('m_job_vacancy_file.id_job_vacancy_dtl',base64_decode($id))->get();
        
        $dt_list_item =  JobVacancyDetailModel::where('id',base64_decode($id))->first();
            
            $data['posted_date']  = Carbon::parse($dt_list_item->posted_date)->format('d/m/Y');
            $data['close_date']  = Carbon::parse($dt_list_item->close_date)->format('d/m/Y');
    
        $data['iddtl']=base64_decode($id);

        return view('pages.jobvacancy_edit', $data);
    }


    public function storeJobVacancy(Request $req)
    {
       
        try {
            $startdate = Carbon::createFromFormat('m/d/Y', $req->startdate)->format('Y-m-d');
            $enddate = Carbon::createFromFormat('m/d/Y', $req->enddate)->format('Y-m-d');
            $listItem = new JobVacancyDetailModel();
            $listItem->id_job_m_vacancy        = $req->category;
            $listItem->vacancy_name            = $req->vacancy_name;
            $listItem->location                = $req->location;
            $listItem->status_vacancy          = $req->status_vacancy;
            $listItem->posted_date             = $startdate;
            $listItem->close_date              = $enddate;
            $listItem->salary                  = $req->salarytraining;
            $listItem->vacancy_level              = $req->vacancy_level;
            $listItem->status              = $req->status;
            $listItem->vacancy_description       = (new HelperController)->scriptStripper( $req->requirements ?? '-');
          
            $listItem->insert_by = session()->get('id');
            $listItem->updated_by = session()->get('id');
            $listItem->updated_by_ip = $req->ip();
            

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
                    
                        $datapenulis = new JobVacancyFilesModel();
                        $datapenulis->id_job_vacancy_dtl = $listItem->id;
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

    

    public function PopUpJobVacancyDetail($id)
    {
       
        try {
                $dt_list_item =  JobVacancyDetailModel::find($id);
                $output = View::make("components.job-vacancy-component")
                    ->with("dataPages", $dt_list_item)
                    ->with("route", route('update-job-vacancy-detail'))
                    ->with("formId", "job-vacancy-edit")
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


    public function updateJobVacancy(Request $req)
    {
       
        //dd($req->all());
        try {
            
           
            $startdate = Carbon::createFromFormat('m/d/Y', $req->startdate)->format('Y-m-d');
            $enddate = Carbon::createFromFormat('m/d/Y', $req->enddate)->format('Y-m-d');
            $listItem = JobVacancyDetailModel::find($req->iddtl);
            $listItem->id_job_m_vacancy        = $req->category;
            $listItem->vacancy_name            = $req->vacancy_name;
            $listItem->location                = $req->location;
            $listItem->status_vacancy          = $req->status_vacancy;
            $listItem->posted_date             = $startdate;
            $listItem->close_date              = $enddate;
            $listItem->salary                  = $req->salarytraining;
            $listItem->vacancy_level           = $req->vacancy_level;
            $listItem->status              = $req->status;
            $listItem->vacancy_description       = (new HelperController)->scriptStripper( $req->requirements ?? '-');
          
            $listItem->insert_by = session()->get('id');
            $listItem->updated_by = session()->get('id');
            $listItem->updated_by_ip = $req->ip();

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
                    
                        $datapenulis = new JobVacancyFilesModel();
                        $datapenulis->id_job_vacancy_dtl = $req->iddtl;
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

    

    public function deleteJobVacancyDetail($id, Request $req)
    {
        try {
            $dt_list_item =  JobVacancyDetailModel::destroy($id);

            if ($dt_list_item) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data berhasil dihapus',
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Data gagal dihapus, Ulangi kembali',
                ];
            }
        } catch (Exception $e) {
            $response = [
                'status' => 'failed',
                'message' => "Terjadi Kesalahan pada sistem.",
            ];
        }

        $log_app = new LogApp();
        $log_app->method = $req->method();
        $log_app->request =  "Delete ProductServiceList";
        $log_app->response =  json_encode($response);
        $log_app->pages = 'Laporan Tahunan';
        $log_app->user_id = session()->get('id');
        $log_app->ip_address = $req->ip();
        $log_app->save();
        return json_encode($response);
    }


}
