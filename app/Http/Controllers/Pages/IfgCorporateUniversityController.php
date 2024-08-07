<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HelperController;
use App\Models\ListItemModel;
use App\Models\LogApp;
use App\Models\MenuModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class IfgCorporateUniversityController extends Controller
{
    public function index($id)
    {
        $data['menus'] = MenuModel::find(base64_decode($id));
        $data['title']      = 'IFG | Pages';
        $data['title_page'] = 'IFG Corporate University | ' . $data['menus']->menu_name;
        $data['menu']       = MenuModel::all();
        $data['dataContent']       = ListItemModel::where('id_menu', base64_decode($id))->first();
        return view('pages.ifg_corp_university', $data);
    }

    public function storePages(Request $req)
    {
        try {
            $req->validate([
                'item_file' => 'mimes:jpeg,png,jpg|max:100000',
                'title' => 'required',
                'title_en' => 'required',
                'description' => 'required',
                'description_en' => 'required',
            ], [
                'item_file.required' => 'Please fill this column',
                'title.required' => 'Please fill this column',
                'title_en.required' => 'Please fill this column',
                'description.required' => 'Please fill this column',
                'description_en.required' => 'Please fill this column',
            ]);

            $dt_list_item =  ListItemModel::find(base64_decode($req->idSP));

            if ($dt_list_item != null) {

                $filename = $dt_list_item->item_file;
                $chkOrder = ListItemModel::where('id_pages_content_order', $dt_list_item->id_pages_content_order)->where('id_menu', $dt_list_item->id_menu)->get();
                if (count($chkOrder) <= 1) {
                    $order = 1;
                } else {
                    $order = count($chkOrder) + 1;
                }
            } else {
                $order = 1;
            }

            if (!is_null($req->file('item_file'))) {

                $manager                = new ImageManager();
                $ext                    =  $req->file('item_file')->extension();
                $img                    = $manager->make($req->file('item_file')->getPathname());
                $filename         = uniqid() . '.' . $req->file('item_file')->getClientOriginalExtension();

                if ($ext == 'png' || $ext == 'PNG') {
                    $filename = uniqid() . '.' . 'webp';
                }

                $img->save(public_path('storage') . '/'  . $filename, 80);

                if (env('PLATFORM_NAME') !== 'windows') {
                    //SFTP
                    Storage::disk('sftp')->put('/' . $filename, $img);
                } else {
                    Storage::disk('windows_uploads')->put('/' . $filename, $img);
                }
            }

            $listItem = ListItemModel::updateOrCreate([
                'id' => base64_decode($req->idSP)
            ], [
                'id_menu' => base64_decode($req->pages),
                'id_pages_content_order' => $req->id_content_order,
                'item_order' => $order,
                'item_title' => (new HelperController)->scriptStripper($req->title ?? ''),
                'item_title_en' => (new HelperController)->scriptStripper($req->title_en ?? ''),
                'item_body' => (new HelperController)->scriptStripper($req->description ?? ''),
                'item_body_en' => (new HelperController)->scriptStripper($req->description_en ?? ''),
                'item_link' => (new HelperController)->scriptStripper($req->url ?? ''),
                'item_file' => $filename ?? '',
                'insert_by' => session()->get('id'),
                'updated_by' => session()->get('id'),
                'updated_by_ip' => $req->ip()
            ]);
            $listItem->save();

            if (!empty($req->side_list) && !empty($req->side_list_en))
                $this->storeSideList($req, $listItem->id);


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
        $log_app->request =  "Store IFG Corporate Univesity";
        $log_app->response =  json_encode($response);
        $log_app->pages = 'IFG Corporate University';
        $log_app->user_id = session()->get('id');
        $log_app->ip_address = $req->ip();
        $log_app->save();

        return json_encode($response);
    }
}
