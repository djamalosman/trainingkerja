<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\LaporanTahunanController;
use App\Http\Controllers\InsightContoller;
use App\Http\Controllers\Pages\BerandaController;
use App\Http\Controllers\Pages\JobVacancyController;
use App\Http\Controllers\Pages\NewsUpdateController;
use App\Http\Controllers\Pages\ContactUsController;
use App\Http\Controllers\Pages\DashboardController;
use App\Http\Controllers\Pages\FooterController;
use App\Http\Controllers\Pages\IfgCorporateUniversityController;
use App\Http\Controllers\Pages\IfgProgressController;
use App\Http\Controllers\Pages\KarirController;
use App\Http\Controllers\Pages\KeterbukaanInformasiPublikController;
use App\Http\Controllers\Pages\PedomanTataKelolaPerusahaanController;
use App\Http\Controllers\Pages\PengandaanTenderUmumController;
use App\Http\Controllers\Pages\ProdukDanLayananController;
use App\Http\Controllers\Pages\TentangKamiController;
use App\Http\Controllers\Pages\WhistleblowingController;
use App\Http\Controllers\pages\TrainingCourseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



    //*beranda

    Route::get('/index', [BerandaController::class, 'index'])
        ->name('index');

    Route::post('/beranda-store-first-slider', [BerandaController::class, 'storeFirstSlider'])
        ->name('beranda-store-first-slider');

    Route::put('/beranda-detail-item-update', [BerandaController::class, 'updateSlider'])
        ->name('beranda-detail-item-update');

    Route::get('/beranda-detail-item-edit/{id}', [BerandaController::class, 'editListItem'])
        ->name('beranda-detail-item-edit');

    Route::get('/beranda-detail-item-delete/{id}', [BerandaController::class, 'deleteListItem'])
        ->name('beranda-detail-item-delete');

    Route::post('/beranda-store-youtube', [BerandaController::class, 'storeYoutube'])
        ->name('beranda-store-youtube');

    


    //Produk dan Layanan
    Route::get('/product-and-service/{id}', [ProdukDanLayananController::class, 'index'])
        ->name('product-and-service');

    Route::get('/edit-produk-dan-layanan/{id}', [ProdukDanLayananController::class, 'editProdukDanLayanan'])
        ->name('edit-produk-dan-layanan');

    Route::post('/store-produk-dan-layanan', [ProdukDanLayananController::class, 'storeKontenDetail'])
        ->name('store-produk-dan-layanan');

    Route::post('/store-kontak-produk-dan-layanan', [ProdukDanLayananController::class, 'storeKontakDetail'])
        ->name('store-kontak-produk-dan-layanan');

    Route::post('/store-produk-dan-layanan-list', [ProdukDanLayananController::class, 'storeProductServiceList'])
        ->name('store-produk-dan-layanan-list');

    Route::get('/delete-produk-dan-layanan-list/{id}', [ProdukDanLayananController::class, 'deleteProductServiceList'])
        ->name('delete-produk-dan-layanan-list');

    Route::get('/edit-product-list/{id}', [ProdukDanLayananController::class, 'showModalProduct'])
        ->name('edit-product-list');

    Route::put('/update-product-list', [ProdukDanLayananController::class, 'updateProductServiceList'])
        ->name('update-product-list');

    Route::post('/store-produk-dan-layanan-list-apps', [ProdukDanLayananController::class, 'storeProductServiceListApp'])
        ->name('store-produk-dan-layanan-list-apps');

    Route::post('/store-produk-dan-layanan-galerry', [ProdukDanLayananController::class, 'storeProductServicePicture'])
        ->name('store-produk-dan-layanan-galerry');

    Route::get('/delete-produk-dan-layanan-galerry/{id}', [ProdukDanLayananController::class, 'deleteProductServiceGallry'])
        ->name('delete-produk-dan-layanan-galerry');

    //publikasi
    Route::get('/annual-report/{id}', [LaporanTahunanController::class, 'index'])
        ->name('annual-report');

    Route::post('/store-laporan-tahunan', [LaporanTahunanController::class, 'storeLaporanTahunan'])
        ->name('store-laporan-tahunan');

    Route::post('/store-laporan-tahunan-list', [LaporanTahunanController::class, 'storeLaporanTahunanList'])
        ->name('store-laporan-tahunan-list');

    Route::get('/delete-laporan-tahunan-list/{id}', [LaporanTahunanController::class, 'deleteProductServiceList'])
        ->name('delete-laporan-tahunan-list');

    Route::get('/edit-laporan-tahunan-list/{id}', [LaporanTahunanController::class, 'editProductServiceList'])
        ->name('edit-laporan-tahunan-list');

    Route::put('/update-laporan-tahunan-list', [LaporanTahunanController::class, 'updateProductServiceList'])
        ->name('update-laporan-tahunan-list');

    //Tata Kelola Perusahaan
    Route::get('/corporate-governance-guidelines/{id}', [PedomanTataKelolaPerusahaanController::class, 'index'])
        ->name('corporate-governance-guidelines');

    Route::post('/store-pedoman-tata-kelola-perusahaan', [PedomanTataKelolaPerusahaanController::class, 'storePedomanTKP'])
        ->name('store-pedoman-tata-kelola-perusahaan');

    Route::post('/store-pedoman-tata-kelola-perusahaan-list', [PedomanTataKelolaPerusahaanController::class, 'storePedomanTKPList'])
        ->name('store-pedoman-tata-kelola-perusahaan-list');

    Route::get('/edit-pedoman-tata-kelola-perusahaan-list/{id}', [PedomanTataKelolaPerusahaanController::class, 'editPedomanTKPList'])
        ->name('edit-pedoman-tata-kelola-perusahaan-list');

    Route::put('/update-pedoman-tata-kelola-perusahaan-list', [PedomanTataKelolaPerusahaanController::class, 'updatePedomanTKPList'])
        ->name('update-pedoman-tata-kelola-perusahaan-list');

    Route::get('/public-information-disclosure/{id}', [KeterbukaanInformasiPublikController::class, 'index'])
        ->name('public-information-disclosure');

    Route::post('/store-keterbukaan-informasi-publik', [KeterbukaanInformasiPublikController::class, 'storeKip'])
        ->name('store-keterbukaan-informasi-publik');

    Route::get('/whistleblowing-system/{id}', [WhistleblowingController::class, 'index'])
        ->name('whistleblowing-system');

    Route::post('/store-whistleblowing-system', [WhistleblowingController::class, 'storeWBS'])
        ->name('store-whistleblowing-system');

    Route::post('/store-whistleblowing-system-list', [WhistleblowingController::class, 'storeWBSList'])
        ->name('store-whistleblowing-system-list');

    Route::get('/edit-list-detail-wbs/{id}', [WhistleblowingController::class, 'editWBSList'])
        ->name('edit-list-detail-wbs');

    Route::put('/update-wbs-list', [WhistleblowingController::class, 'updateWBSList'])
        ->name('update-wbs-list');

    Route::get('/insight/{id}', [InsightContoller::class, 'index'])
        ->name('insight');

    Route::post('/store-insight', [InsightContoller::class, 'storeinsight'])
        ->name('store-insight');

    Route::post('/store-insight-list', [InsightContoller::class, 'storeinsightList'])
        ->name('store-insight-list');

    //karir
    Route::get('/life-at-ifg/{id}', [KarirController::class, 'karir'])
        ->name('life-at-ifg');

    Route::post('/store-karir', [KarirController::class, 'storeKarir'])
        ->name('store-karir');

    Route::post('/store-karir-youtube', [KarirController::class, 'storeKarirYoutube'])
        ->name('store-karir-youtube');

    Route::post('/store-karir-widget', [KarirController::class, 'storeKarirWidget'])
        ->name('store-karir-widget');

    Route::post('/store-karir-widget-youtube', [KarirController::class, 'storeKarirWidgetYoutube'])
        ->name('store-karir-widget-youtube');

    Route::put('/update-karir-widget', [KarirController::class, 'updateKarirWidget'])
        ->name('update-karir-widget');

    Route::put('/update-karir-widget-youtube', [KarirController::class, 'updateKarirWidgetYoutue'])
        ->name('update-karir-widget-youtube');

    Route::post('/store-karir-delete/{id}', [KarirController::class, 'storeKarirDelete'])
        ->name('store-karir-delete');

    Route::get('/rekrutmen/{id}', [KarirController::class, 'rekrutmen'])
        ->name('rekrutmen');

    Route::post('/store-rekrutmen-list', [KarirController::class, 'storeRekrutmenList'])
        ->name('store-rekrutmen-list');

    Route::get('/delete-rekrutmen-list/{id}/{param}', [KarirController::class, 'deleteKarir'])
        ->name('delete-rekrutmen-list');

    Route::get('/edit-list-detail-rekrutmen/{id}', [KarirController::class, 'editRekrutmenList'])
        ->name('edit-list-detail-rekrutmen');

    Route::put('/update-rekrutmen-list', [KarirController::class, 'updateRekrutmenList'])
        ->name('update-rekrutmen-list');

    Route::get('/procurement-tender-general/{id}', [PengandaanTenderUmumController::class, 'index'])
        ->name('procurement-tender-general');

    Route::post('/store-pages', [PengandaanTenderUmumController::class, 'storePages'])
        ->name('store-pages');

    Route::get('/ifg-corporate-university/{id}', [IfgCorporateUniversityController::class, 'index'])
        ->name('ifg-corporate-university');

    Route::post('/store-pages-corp-univ', [IfgCorporateUniversityController::class, 'storePages'])
        ->name('store-pages-corp-univ');

    Route::get('/ifg-progress/{id}', [IfgProgressController::class, 'index'])
        ->name('ifg-progress');

    Route::post('/store-pages-progress', [IfgProgressController::class, 'storePages'])
        ->name('store-pages-progress');

    Route::get('/contact-us/{id}', [ContactUsController::class, 'index'])
        ->name('contact-us');

    Route::post('/store-contact-us-list', [ContactUsController::class, 'storeHubungiKamiList'])
        ->name('store-contact-us-list');

    Route::get('/edit-list-detail-hubungi-kami/{id}', [ContactUsController::class, 'editHubungiKamiList'])
        ->name('edit-list-detail-hubungi-kami');

    Route::put('/update-hubungi-kami-list', [ContactUsController::class, 'updateHubungiKamiList'])
        ->name('update-hubungi-kami-list');

    Route::get('/footer/{id}', [FooterController::class, 'index'])
        ->name('footer');

    Route::post('/store-footer', [FooterController::class, 'storeFooterList'])
        ->name('store-footer');

    Route::get('/edit-list-detail-footer/{id}', [FooterController::class, 'editFooterList'])
        ->name('edit-list-detail-footer');

    Route::put('/update-footer-list', [FooterController::class, 'updateFooterList'])
        ->name('update-footer-list');


    Route::post('/update-slider-video', [BerandaController::class, 'updateSliderVideo'])
        ->name('update-slider-video');

    Route::get('/beranda-toggle-video/{id}/{param1}', [BerandaController::class, 'activateVideo'])
        ->name('beranda-toggle-video');

    // test
    Route::get('/storeImage', [BerandaController::class, 'fileStore'])
        ->name('storeImage');

    Route::get('/storeIg', [HelperController::class, 'storeIg'])
        ->name('storeIg');

    Route::get('/refreshTokenIg', [HelperController::class, 'refreshTokenIg'])
        ->name('refreshTokenIg');

    Route::get('/phpinfo', [HelperController::class, 'phpinfo'])
        ->name('phpinfo');

    Route::get('/insertApiGallery', [HelperController::class, 'insertApiGallery'])
        ->name('insertApiGallery');

    Route::get('/insertApiNews', [HelperController::class, 'insertApiNews'])
        ->name('insertApiNews');

    Route::get('/newsDetail', [HelperController::class, 'newsDetail'])
        ->name('newsDetail');

//traning kerja

        // Awal

            Route::middleware('guest')->group(function () {
                Route::get('/', [AuthController::class, 'index'])
                    ->name('login');

                Route::post('/login', [AuthController::class, 'store'])
                    ->name('login-action');
            });

            Route::middleware('auth')->group(function () {
                Route::post('logout', [AuthController::class, 'destroy'])
                    ->name('logout');

            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');

            Route::post('/ubah-password', [BerandaController::class, 'updatePassword'])
                ->name('ubah-password');

        //Tentang Kami
            Route::get('/company-overview/{id}', [TentangKamiController::class, 'sekilasPerusahaan'])
                ->name('company-overview');

            Route::post('/store-company-overview', [TentangKamiController::class, 'storeSekilasPerusahaan'])
                ->name('store-company-overview');

            Route::get('/vision-mission/{id}', [TentangKamiController::class, 'visiMisi'])
                ->name('vision-mission');

            Route::post('/store-visi-misi', [TentangKamiController::class, 'storeVisiMisi'])
                ->name('store-visi-misi');

            Route::get('/edit-visi-misi/{id}', [TentangKamiController::class, 'editVisiMisi'])
                ->name('edit-visi-misi');

            Route::post('/update-title-visi-misi', [TentangKamiController::class, 'updateTitleVisiMisi'])
                ->name('update-title-visi-misi');

            Route::post('/update-visi-misi', [TentangKamiController::class, 'updateVisiMisi'])
                ->name('update-visi-misi');

            Route::put('/update-visi-misi-detail', [TentangKamiController::class, 'updateVisiMisiDetail'])
                ->name('update-visi-misi-detail');

            Route::get('/edit-list-detail-tk/{id}', [TentangKamiController::class, 'editListItemDetail'])
                ->name('edit-list-detail-tk');

            Route::get('/edit-profile-manajemen/{id}', [TentangKamiController::class, 'editProfileManajemen'])
                ->name('edit-profile-manajemen');

            Route::get('/profile-manajemen-edit-list/{id}', [TentangKamiController::class, 'modalProfileManajemen'])
                ->name('profile-manajemen-edit-list');

            Route::put('/update-profile-manajemen', [TentangKamiController::class, 'updateProfileManajemen'])
                ->name('update-profile-manajemen');

            Route::get('/history/{id}', [TentangKamiController::class, 'sejarahKami'])
                ->name('history');

            Route::post('/store-history', [TentangKamiController::class, 'storeSejarahKami'])
                ->name('store-history');

            Route::put('/update-history', [TentangKamiController::class, 'updateSejarahKamiDetail'])
                ->name('update-history');

            Route::get('/management-profile/{id}', [TentangKamiController::class, 'profileManajemen'])
                ->name('management-profile');

            Route::post('/store-profil-manajemen', [TentangKamiController::class, 'storeProfilManajemen'])
                ->name('store-profil-manajemen');

            Route::get('/subsidiaries/{id}', [TentangKamiController::class, 'anakPerusahaan'])
                ->name('subsidiaries');

            Route::post('/store-anak-perusahaan', [TentangKamiController::class, 'storeAnakPerusahaan'])
                ->name('store-anak-perusahaan');

            Route::get('/award-and-certificate/{id}', [TentangKamiController::class, 'penghargaanSertifikat'])
                ->name('award-and-certificate');

            Route::post('/store-penghargaan-dan-sertifikat', [TentangKamiController::class, 'storePenghargaanSertifikat'])
                ->name('store-penghargaan-dan-sertifikat');

            Route::get('/edit-penghargaan-dan-sertifikat/{id}', [TentangKamiController::class, 'editPernghargaanSertifikat'])
                ->name('edit-penghargaan-dan-sertifikat');

            Route::put('/update-penghargaan-dan-sertifikat', [TentangKamiController::class, 'updatePernghargaanSertifikat'])
                ->name('update-penghargaan-dan-sertifikat');

            Route::put('/beranda-update-anggota-holding', [BerandaController::class, 'updateAnggotaHolding'])
                ->name('beranda-update-anggota-holding');

        //helper
            Route::get('/pages-list-detail-delete/{id}', [HelperController::class, 'deleteListItemDetail'])
                ->name('pages-list-detail-delete');

            Route::get('/edit-list-detail/{id}', [HelperController::class, 'editListItemDetail'])
                ->name('edit-list-detail');

            Route::post('/store-page-header', [HelperController::class, 'storePageHeader'])
                ->name('store-page-header');

            Route::post('/store-side-list', [HelperController::class, 'storeSideList'])
                ->name('store-side-list');

            Route::post('/update-side-list', [HelperController::class, 'updateOnlySideList'])
                ->name('update-side-list');

            Route::post('/store-anggota-holding', [HelperController::class, 'storeAnggotaHolding'])
                ->name('store-anggota-holding');

            Route::get('/delete-side-list/{id}', [HelperController::class, 'deleteSideList'])
                ->name('delete-side-list');

            Route::get('/anggota-holding-delete/{id}', [HelperController::class, 'deleteAnggotaHolding'])
                ->name('anggota-holding-delete');

            Route::get('/edit-list-anggot-holding/{id}', [BerandaController::class, 'editListAnggotaHolding'])
                ->name('edit-list-anggot-holding');

    // training course

            Route::get('/traningcourse/{id}', [TrainingCourseController::class, 'traningcourse'])
                ->name('traningcourse');

            Route::get('/get-datacourse-filters', [TrainingCourseController::class, 'getFilters'])
                ->name('get-datacourse-filters');

            Route::get('/get-data-course', [TrainingCourseController::class, 'getDataCourses'])
                ->name('get-data-course');

            Route::get('/get-view-store-traningcourse/{id}', [TrainingCourseController::class, 'ViewsStoretraningcourse'])
                ->name('get-view-store-traningcourse');

            Route::post('/store-course-endpoint', [TrainingCourseController::class, 'storeCourseEndpoint'])->name('store-course-endpoint');

            Route::post('/update-course-endpoint', [TrainingCourseController::class, 'updateCourseEndpoint'])->name('update-course-endpoint');



            Route::post('/store-course', [TrainingCourseController::class, 'storeCourse'])
                ->name('store-course');

            Route::get('/edit-traningcourse/{id}', [TrainingCourseController::class, 'editTraningCourse'])
                ->name('edit-traningcourse');


            Route::post('/update-traning-course', [TrainingCourseController::class, 'updateTraningCourse'])
                ->name('update-traning-course');

            Route::get('/edit-traningcourse-detail/{id}', [TrainingCourseController::class, 'editTraningCourseDetail'])
                ->name('edit-traningcourse-detail');

            Route::put('/update-traning-course-detail', [TrainingCourseController::class, 'updateTraningCourseDetail'])
                ->name('update-traning-course-detail');    
    
    
    // job vacancy

            Route::get('/jobvacancy/{id}', [JobVacancyController::class, 'jobVacancy'])
                ->name('jobvacancy');

            Route::get('/get-data-job', [JobVacancyController::class, 'getDataJobFilter'])
                ->name('get-data-job');

            Route::get('/get-filters-job', [JobVacancyController::class, 'getDropdownJob'])
                ->name('get-filters-job');

            Route::get('/get-view-store-jobvacancy/{id}', [JobVacancyController::class, 'getViewStoreJobvacancy'])
                ->name('get-view-store-jobvacancy');

            Route::get('/delete-master-job-cavancy/{id}', [JobVacancyController::class, 'deleteJobVacancyMaster'])
                ->name('delete-master-job-cavancy');

            Route::post('/store-jobvacancy', [JobVacancyController::class, 'storeJobVacancy'])
                ->name('store-jobvacancy');


            Route::get('/edit-jobvacancy/{id}', [JobVacancyController::class, 'editJobVacancy'])
                ->name('edit-jobvacancy');

            Route::post('/update-job-vacancy', [JobVacancyController::class, 'updateJobVacancy'])
                ->name('update-job-vacancy');

            Route::get('/delete-master-job-cavancy-detail/{id}', [JobVacancyController::class, 'deleteJobVacancyDetail'])
                ->name('delete-master-job-cavancy-detail');



            Route::get('/edit-jobvacancy-detail/{id}', [JobVacancyController::class, 'editJobVacancyDetail'])
                ->name('edit-jobvacancy-detail');

            Route::put('/update-job-vacancy-detail', [JobVacancyController::class, 'updateJobVacancyDetail'])
                ->name('update-job-vacancy-detail');
            
    

    // news & update

            Route::get('/newsupdate/{id}', [NewsUpdateController::class, 'newsUpdate'])
                ->name('newsupdate');
            
            Route::get('/get-data-news', [NewsUpdateController::class, 'getDataNewsFilter'])
                ->name('get-data-news');

            Route::get('/get-filters-news', [NewsUpdateController::class, 'getDropdownNews'])
                ->name('get-filters-news');
        
           
            Route::get('/get-view-store-news/{id}', [NewsUpdateController::class, 'getViewStoreNews'])
                ->name('get-view-store-news');

                Route::post('/store-news-update', [NewsUpdateController::class, 'storeNewsUpdate'])
                ->name('store-news-update');



            Route::get('/edit-newsupdate/{id}', [NewsUpdateController::class, 'editNewsUpdate'])
                ->name('edit-newsupdate');

            Route::post('/update-news-update', [NewsUpdateController::class, 'updateNewsUpdate'])
                ->name('update-news-update');

            // Route::get('/delete-master-job-cavancy-detail/{id}', [JobVacancyController::class, 'deleteJobVacancyDetail'])
            //     ->name('delete-master-job-cavancy-detail');



            Route::get('/edit-NewsUpdate-detail/{id}', [NewsUpdateController::class, 'editNewsUpdateDetail'])
                ->name('edit-NewsUpdate-detail');

            Route::put('/update-news-update-detail', [NewsUpdateController::class, 'updateNewsUpdateDetail'])
                ->name('update-news-update-detail');
            
});
