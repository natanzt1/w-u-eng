<?php

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

#Pindah Role
Route::middleware(['roleauth'])->group(function(){
    Route::get('/service/role/change/{id}', function($id){
        $role = session()->get('role');
        $selected = $role->where('brokerrole_id', $id)->first();
        if (empty($selected)) {
            return response()->json([
                'status'    => false,
                'msg'   => 'Invalid selected role'
            ], 500);
        }

        session()->put('currentRole', $selected);
        // return (array)session()->get('currentRole');
        return redirect('/');
    });
});
#

Route::get('/', 'Guest\HomeController@index')->name('id.home');
Route::get('/en', 'Guest\HomeController@indexEnglish')->name('en.home');
Route::get('/2', 'Guest\HomeController@index2');
Route::get('auth', '\App\SSO\AuthRequest@logout')->name('sso.logout');

Route::middleware(['roleauth'])->group(function () {
    Route::group(['prefix' => 'administrator'],function() {
        Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

        //berita
        Route::get('/berita/', 'BeritaController@Index')->name('admin.berita.index');
        Route::get('/berita/index', 'BeritaController@Index')->name('admin.berita.index');
        Route::get('/berita/{slug}/show', 'BeritaController@Show')->name('admin.berita.show');
        Route::get('/berita/create', 'BeritaController@Create')->name('admin.berita.create');
        Route::post('/berita/', 'BeritaController@Store')->name('admin.berita.store');
        Route::get('/berita/{slug}/active', 'BeritaController@Active')->name('admin.berita.active');
        Route::get('/berita/{slug}/nonactive', 'BeritaController@NonActive')->name('admin.berita.nonactive');
        Route::post('/berita/{slug}/update', 'BeritaController@Update')->name('admin.berita.update');
        Route::get('/berita/{slug}/edit', 'BeritaController@Edit')->name('admin.berita.edit');
        Route::get('/berita/{slug}/thumbnail', 'BeritaController@Thumbnail')->name('admin.berita.thumbnail');
        Route::get('/berita/{slug}/nonthumbnail', 'BeritaController@NonThumbnail')->name('admin.berita.nonthumbnail');
        Route::post('/berita/{slug}/delete', 'BeritaController@Delete')->name('admin.berita.delete');

        //berita_ayurweda
        Route::get('/berita_ayurweda/', 'BeritaAyurwedaController@Index')->name('admin.berita_ayurweda.index');
        Route::get('/berita_ayurweda/index', 'BeritaAyurwedaController@Index')->name('admin.berita_ayurweda.index');
        Route::get('/berita_ayurweda/{slug}/show', 'BeritaAyurwedaController@Show')->name('admin.berita_ayurweda.show');
        Route::get('/berita_ayurweda/create', 'BeritaAyurwedaController@Create')->name('admin.berita_ayurweda.create');
        Route::post('/berita_ayurweda/', 'BeritaAyurwedaController@Store')->name('admin.berita_ayurweda.store');
        Route::get('/berita_ayurweda/{slug}/active', 'BeritaAyurwedaController@Active')->name('admin.berita_ayurweda.active');
        Route::get('/berita_ayurweda/{slug}/nonactive', 'BeritaAyurwedaController@NonActive')->name('admin.berita_ayurweda.nonactive');
        Route::post('/berita_ayurweda/{slug}/update', 'BeritaAyurwedaController@Update')->name('admin.berita_ayurweda.update');
        Route::get('/berita_ayurweda/{slug}/edit', 'BeritaAyurwedaController@Edit')->name('admin.berita_ayurweda.edit');
        Route::get('/berita_ayurweda/{slug}/thumbnail', 'BeritaAyurwedaController@Thumbnail')->name('admin.berita_ayurweda.thumbnail');
        Route::get('/berita_ayurweda/{slug}/nonthumbnail', 'BeritaAyurwedaController@NonThumbnail')->name('admin.berita_ayurweda.nonthumbnail');
        Route::post('/berita_ayurweda/{slug}/delete', 'BeritaAyurwedaController@Delete')->name('admin.berita_ayurweda.delete');


    //Pengumuman
        Route::get('/pengumuman/', 'PengumumanController@Index')->name('admin.pengumuman.index');
        Route::get('/pengumuman/index', 'PengumumanController@Index')->name('admin.pengumuman.index');
        Route::get('/pengumuman/{slug}/show', 'PengumumanController@Show')->name('admin.pengumuman.show');
        Route::get('/pengumuman/create', 'PengumumanController@Create')->name('admin.pengumuman.create');
        Route::post('/pengumuman/', 'PengumumanController@Store')->name('admin.pengumuman.store');
        Route::get('/pengumuman/{slug}/active', 'PengumumanController@Active')->name('admin.pengumuman.active');
        Route::get('/pengumuman/{slug}/nonactive', 'PengumumanController@NonActive')->name('admin.pengumuman.nonactive');
        Route::get('/pengumuman/{slug}/edit', 'PengumumanController@Edit')->name('admin.pengumuman.edit');
        Route::post('/pengumuman/{slug}/update', 'PengumumanController@Update')->name('admin.pengumuman.update');
        Route::post('/pengumuman/{slug}/delete', 'PengumumanController@Delete')->name('admin.pengumuman.delete');


        //Slider
        Route::get('/slider/', 'SliderController@Index')->name('admin.slider.index');
        Route::get('/slider/index', 'SliderController@Index')->name('admin.slider.index');
        Route::get('/slider/{slug}/show', 'SliderController@Show')->name('admin.slider.show');
        Route::get('/slider/create', 'SliderController@Create')->name('admin.slider.create');
        Route::post('/slider/', 'SliderController@Store')->name('admin.slider.store');
        Route::get('/slider/{slug}/active', 'SliderController@Active')->name('admin.slider.active');
        Route::get('/slider/{slug}/nonactive', 'SliderController@NonActive')->name('admin.slider.nonactive');
        Route::get('/slider/{slug}/edit', 'SliderController@Edit')->name('admin.slider.edit');
        Route::post('/slider/{slug}/update', 'SliderController@Update')->name('admin.slider.update');
        Route::post('/slider/{slug}/delete', 'SliderController@Delete')->name('admin.slider.delete');

        //Agama Budaya
        Route::get('/agama/', 'AgamaBudayaController@Index')->name('admin.agamabudaya.index');
        Route::get('/agama/index', 'AgamaBudayaController@Index')->name('admin.agamabudaya.index');
        Route::get('/agama/{slug}/show', 'AgamaBudayaController@Show')->name('admin.agamabudaya.show');
        Route::get('/agama/create', 'AgamaBudayaController@Create')->name('admin.agamabudaya.create');
        Route::post('/agama/', 'AgamaBudayaController@Store')->name('admin.agamabudaya.store');
        Route::get('/agama/{slug}/active', 'AgamaBudayaController@Active')->name('admin.agamabudaya.active');
        Route::get('/agama/{slug}/nonactive', 'AgamaBudayaController@NonActive')->name('admin.agamabudaya.nonactive');
        Route::get('/agama/{slug}/edit', 'AgamaBudayaController@Edit')->name('admin.agamabudaya.edit');
        Route::post('/agama/{slug}/update', 'AgamaBudayaController@Update')->name('admin.agamabudaya.update');
        Route::post('/agama/{slug}/delete', 'AgamaBudayaController@Delete')->name('admin.agamabudaya.delete');
        Route::get('/agama/{slug}/active/en', 'AgamaBudayaController@ActiveEN')->name('admin.agamabudaya.active.en');
        Route::get('/agama/{slug}/nonactive/en', 'AgamaBudayaController@NonActiveEN')->name('admin.agamabudaya.nonactive.en');

        //Inkubator
        Route::get('/inkubator/', 'InkubatorController@Index')->name('admin.inkubator.index');
        Route::get('/inkubator/index', 'InkubatorController@Index')->name('admin.inkubator.index');
        Route::get('/inkubator/{slug}/show', 'InkubatorController@Show')->name('admin.inkubator.show');
        Route::get('/inkubator/create', 'InkubatorController@Create')->name('admin.inkubator.create');
        Route::post('/inkubator/', 'InkubatorController@Store')->name('admin.inkubator.store');
        Route::get('/inkubator/{slug}/active', 'InkubatorController@Active')->name('admin.inkubator.active');
        Route::get('/inkubator/{slug}/nonactive', 'InkubatorController@NonActive')->name('admin.inkubator.nonactive');
        Route::get('/inkubator/{slug}/edit', 'InkubatorController@Edit')->name('admin.inkubator.edit');
        Route::post('/inkubator/{slug}/update', 'InkubatorController@Update')->name('admin.inkubator.update');
        Route::post('/inkubator/{slug}/delete', 'InkubatorController@Delete')->name('admin.inkubator.delete');

        //tentang
        Route::get('/tentang/', 'TentangController@Index')->name('admin.tentang.index');
        Route::get('/tentang/index', 'TentangController@Index')->name('admin.tentang.index');
        Route::get('/tentang/{slug}/show', 'TentangController@Show')->name('admin.tentang.show');
        Route::get('/tentang/create', 'TentangController@Create')->name('admin.tentang.create');
        Route::post('/tentang/', 'TentangController@Store')->name('admin.tentang.store');
        Route::get('/tentang/{slug}/active', 'TentangController@Active')->name('admin.tentang.active');
        Route::get('/tentang/{slug}/nonactive', 'TentangController@NonActive')->name('admin.tentang.nonactive');
        Route::get('/tentang/{slug}/edit', 'TentangController@Edit')->name('admin.tentang.edit');
        Route::post('/tentang/{slug}/update', 'TentangController@Update')->name('admin.tentang.update');
        Route::post('/tentang/{slug}/delete', 'TentangController@Delete')->name('admin.tentang.delete');

        //UKM
        Route::get('/ukm/', 'UkmController@Index')->name('admin.ukm.index');
        Route::get('/ukm/index', 'UkmController@Index')->name('admin.ukm.index');
        Route::get('/ukm/{slug}/show', 'UkmController@Show')->name('admin.ukm.show');
        Route::get('/ukm/create', 'UkmController@Create')->name('admin.ukm.create');
        Route::post('/ukm/', 'UkmController@Store')->name('admin.ukm.store');
        Route::get('/ukm/{slug}/active', 'UkmController@Active')->name('admin.ukm.active');
        Route::get('/ukm/{slug}/nonactive', 'UkmController@NonActive')->name('admin.ukm.nonactive');
        Route::get('/ukm/{slug}/edit', 'UkmController@Edit')->name('admin.ukm.edit');
        Route::post('/ukm/{slug}/update', 'UkmController@Update')->name('admin.ukm.update');
        Route::post('/ukm/{slug}/delete', 'UkmController@Delete')->name('admin.ukm.delete');

        //fakultas
        Route::get('/fakultas/', 'FakultasController@Index')->name('admin.fakultas.index');
        Route::get('/fakultas/index', 'FakultasController@Index')->name('admin.fakultas.index');
        Route::get('/fakultas/{slug}/show', 'FakultasController@Show')->name('admin.fakultas.show');
        Route::get('/fakultas/create', 'FakultasController@Create')->name('admin.fakultas.create');
        Route::post('/fakultas/', 'FakultasController@Store')->name('admin.fakultas.store');
        Route::get('/fakultas/{slug}/active', 'FakultasController@Active')->name('admin.fakultas.active');
        Route::get('/fakultas/{slug}/nonactive', 'FakultasController@NonActive')->name('admin.fakultas.nonactive');
        Route::get('/fakultas/{slug}/edit', 'FakultasController@Edit')->name('admin.fakultas.edit');
        Route::post('/fakultas/{slug}/update', 'FakultasController@Update')->name('admin.fakultas.update');
        Route::post('/fakultas/{slug}/delete', 'FakultasController@Delete')->name('admin.fakultas.delete');
        Route::get('/fakultas/{slug}/detail', 'FakultasController@Gallery')->name('admin.fakultas.detail');
        Route::post('/fakultas/detail/{slug}/store', 'FakultasController@StoreGallery')->name('admin.fakultas.storedetail');
        Route::post('/fakultas/detail/{slug}/delete/{id}', 'FakultasController@DeleteGallery')->name('admin.fakultas.deteledetail');

        //Prodi
        Route::get('/prodi/', 'ProdiController@Index')->name('admin.prodi.index');
        Route::get('/prodi/index', 'ProdiController@Index')->name('admin.prodi.index');
        Route::get('/prodi/{slug}/show', 'ProdiController@Show')->name('admin.prodi.show');
        Route::get('/prodi/create', 'ProdiController@Create')->name('admin.prodi.create');
        Route::post('/prodi/', 'ProdiController@Store')->name('admin.prodi.store');
        Route::get('/prodi/{slug}/active', 'ProdiController@Active')->name('admin.prodi.active');
        Route::get('/prodi/{slug}/nonactive', 'ProdiController@NonActive')->name('admin.prodi.nonactive');
        Route::get('/prodi/{slug}/edit', 'ProdiController@Edit')->name('admin.prodi.edit');
        Route::post('/prodi/{slug}/update', 'ProdiController@Update')->name('admin.prodi.update');
        Route::post('/prodi/{slug}/delete', 'ProdiController@Delete')->name('admin.prodi.delete');
        Route::get('/prodi/{slug}/detail', 'ProdiController@Gallery')->name('admin.prodi.detail');
        Route::post('/prodi/detail/{slug}/store', 'ProdiController@StoreGallery')->name('admin.prodi.storedetail');
        Route::post('/prodi/detail/{slug}/delete/{id}', 'ProdiController@DeleteGallery')->name('admin.prodi.deteledetail');

        //warta
        Route::get('/warta/', 'WartaController@Index')->name('admin.warta.index');
        Route::get('/warta/index', 'WartaController@Index')->name('admin.warta.index');
        Route::get('/warta/{slug}/show', 'WartaController@Show')->name('admin.warta.show');
        Route::get('/warta/create', 'WartaController@Create')->name('admin.warta.create');
        Route::post('/warta/', 'WartaController@Store')->name('admin.warta.store');
        Route::get('/warta/{slug}/active', 'WartaController@Active')->name('admin.warta.active');
        Route::get('/warta/{slug}/nonactive', 'WartaController@NonActive')->name('admin.warta.nonactive');
        Route::get('/warta/{slug}/edit', 'WartaController@Edit')->name('admin.warta.edit');
        Route::post('/warta/{slug}/update', 'WartaController@Update')->name('admin.warta.update');
        Route::post('/warta/{slug}/delete', 'WartaController@Delete')->name('admin.warta.delete');

        //senat
        Route::get('/senat/', 'SenatController@Index')->name('admin.senat.index');
        Route::get('/senat/index', 'SenatController@Index')->name('admin.senat.index');
        Route::get('/senat/{slug}/show', 'SenatController@Show')->name('admin.senat.show');
        Route::get('/senat/create', 'SenatController@Create')->name('admin.senat.create');
        Route::post('/senat/', 'SenatController@Store')->name('admin.senat.store');
        Route::get('/senat/{slug}/active', 'SenatController@Active')->name('admin.senat.active');
        Route::get('/senat/{slug}/nonactive', 'SenatController@NonActive')->name('admin.senat.nonactive');
        Route::get('/senat/{slug}/edit', 'SenatController@Edit')->name('admin.senat.edit');
        Route::post('/senat/{slug}/update', 'SenatController@Update')->name('admin.senat.update');
        Route::post('/senat/{slug}/delete', 'SenatController@Delete')->name('admin.senat.delete');

        //bem
        Route::get('/bem/', 'BemController@Index')->name('admin.bem.index');
        Route::get('/bem/index', 'BemController@Index')->name('admin.bem.index');
        Route::get('/bem/{slug}/show', 'BemController@Show')->name('admin.bem.show');
        Route::get('/bem/create', 'BemController@Create')->name('admin.bem.create');
        Route::post('/bem/', 'BemController@Store')->name('admin.bem.store');
        Route::get('/bem/{slug}/active', 'BemController@Active')->name('admin.bem.active');
        Route::get('/bem/{slug}/nonactive', 'BemController@NonActive')->name('admin.bem.nonactive');
        Route::get('/bem/{slug}/edit', 'BemController@Edit')->name('admin.bem.edit');
        Route::post('/bem/{slug}/update', 'BemController@Update')->name('admin.bem.update');
        Route::post('/bem/{slug}/delete', 'BemController@Delete')->name('admin.bem.delete');

        //Agenda
        Route::get('/agenda/', 'AgendaController@Index')->name('admin.agenda.index');
        Route::get('/agenda/index', 'AgendaController@Index')->name('admin.agenda.index');
        Route::get('/agenda/{slug}/show', 'AgendaController@Show')->name('admin.agenda.show');
        Route::get('/agenda/create', 'AgendaController@Create')->name('admin.agenda.create');
        Route::post('/agenda/', 'AgendaController@Store')->name('admin.agenda.store');
        Route::get('/agenda/{slug}/active', 'AgendaController@Active')->name('admin.agenda.active');
        Route::get('/agenda/{slug}/nonactive', 'AgendaController@NonActive')->name('admin.agenda.nonactive');
        Route::get('/agenda/{slug}/edit', 'AgendaController@Edit')->name('admin.agenda.edit');
        Route::post('/agenda/{slug}/update', 'AgendaController@Update')->name('admin.agenda.update');
        Route::post('/agenda/{slug}/delete', 'AgendaController@Delete')->name('admin.agenda.delete');

        //VIDEO
        Route::get('/video/', 'VideoController@Index')->name('admin.video.index');
        Route::get('/video/index', 'VideoController@Index')->name('admin.video.index');
        Route::get('/video/{slug}/show', 'VideoController@Show')->name('admin.video.show');
        Route::get('/video/create', 'VideoController@Create')->name('admin.video.create');
        Route::post('/video/', 'VideoController@Store')->name('admin.video.store');
        Route::get('/video/{slug}/active', 'VideoController@Active')->name('admin.video.active');
        Route::get('/video/{slug}/nonactive', 'VideoController@NonActive')->name('admin.video.nonactive');
        Route::get('/video/{slug}/edit', 'VideoController@Edit')->name('admin.video.edit');
        Route::post('/video/{slug}/update', 'VideoController@Update')->name('admin.video.update');
        Route::post('/video/{slug}/delete', 'VideoController@Delete')->name('admin.video.delete');

        //Repository
        Route::get('/repository/', 'RepositoryController@Index')->name('admin.repository.index');
        Route::get('/repository/index', 'RepositoryController@Index')->name('admin.repository.index');
        Route::get('/repository/{slug}/show', 'RepositoryController@Show')->name('admin.repository.show');
        Route::get('/repository/create', 'RepositoryController@Create')->name('admin.repository.create');
        Route::post('/repository/', 'RepositoryController@Store')->name('admin.repository.store');
        Route::get('/repository/{slug}/active', 'RepositoryController@Active')->name('admin.repository.active');
        Route::get('/repository/{slug}/nonactive', 'RepositoryController@NonActive')->name('admin.repository.nonactive');
        Route::get('/repository/{slug}/edit', 'RepositoryController@Edit')->name('admin.repository.edit');
        Route::post('/repository/{slug}/update', 'RepositoryController@Update')->name('admin.repository.update');
        Route::post('/repository/{slug}/delete', 'RepositoryController@Delete')->name('admin.repository.delete');

        //kalender
        Route::get('/kalender/', 'KalenderController@Index')->name('admin.kalender.index');
        Route::get('/kalender/index', 'KalenderController@Index')->name('admin.kalender.index');
        Route::get('/kalender/{slug}/show', 'KalenderController@Show')->name('admin.kalender.show');
        Route::get('/kalender/create', 'KalenderController@Create')->name('admin.kalender.create');
        Route::post('/kalender/', 'KalenderController@Store')->name('admin.kalender.store');
        Route::get('/kalender/{slug}/active', 'KalenderController@Active')->name('admin.kalender.active');
        Route::get('/kalender/{slug}/nonactive', 'KalenderController@NonActive')->name('admin.kalender.nonactive');
        Route::get('/kalender/{slug}/edit', 'KalenderController@Edit')->name('admin.kalender.edit');
        Route::post('/kalender/{slug}/update', 'KalenderController@Update')->name('admin.kalender.update');
        Route::post('/kalender/{slug}/delete', 'KalenderController@Delete')->name('admin.kalender.delete');

        //Gallery
        Route::get('/gallery/', 'GalleryController@Index')->name('admin.gallery.index');
        Route::get('/gallery/{slug}/detail', 'GalleryController@Detail')->name('admin.gallery.detail');
        Route::get('/gallery/index', 'GalleryController@Index')->name('admin.gallery.index');
        Route::get('/gallery/{slug}/show', 'GalleryController@Show')->name('admin.gallery.show');
        Route::get('/gallery/create', 'GalleryController@Create')->name('admin.gallery.create');
        Route::post('/gallery/', 'GalleryController@Store')->name('admin.gallery.store');
        Route::post('/gallery/{slug}/', 'GalleryController@StoreDetail')->name('admin.gallery.detailstore');
        Route::get('/gallery/{slug}/thumbnail/{id}', 'GalleryController@Thumbnail')->name('admin.gallery.thumbnail');
        Route::get('/gallery/{slug}/active', 'GalleryController@Active')->name('admin.gallery.active');
        Route::get('/gallery/{slug}/nonactive', 'GalleryController@NonActive')->name('admin.gallery.nonactive');
        Route::get('/gallery/{slug}/edit', 'GalleryController@Edit')->name('admin.gallery.edit');
        Route::post('/gallery/{slug}/update', 'GalleryController@Update')->name('admin.gallery.update');
        Route::post('/gallery/{slug}/delete/{id}', 'GalleryController@Delete')->name('admin.gallery.delete');

         //Pop Up
        Route::get('/popup/', 'PopupController@Index')->name('admin.popup.index');
        Route::get('/popup/index', 'PopupController@Index')->name('admin.popup.index');
        Route::get('/popup/{slug}/show', 'PopupController@Show')->name('admin.popup.show');
        Route::get('/popup/create', 'PopupController@Create')->name('admin.popup.create');
        Route::post('/popup/', 'PopupController@Store')->name('admin.popup.store');
        Route::get('/popup/{slug}/active', 'PopupController@Active')->name('admin.popup.active');
        Route::get('/popup/{slug}/nonactive', 'PopupController@NonActive')->name('admin.popup.nonactive');
        Route::get('/popup/{slug}/edit', 'PopupController@Edit')->name('admin.popup.edit');
        Route::post('/popup/{slug}/update', 'PopupController@Update')->name('admin.popup.update');
        Route::post('/popup/{slug}/delete', 'PopupController@Delete')->name('admin.popup.delete');

        //Portal
        Route::get('/portal/', 'PortalController@Index')->name('admin.portal.index');
        Route::get('/portal/index', 'PortalController@Index')->name('admin.portal.index');
        Route::get('/portal/{slug}/show', 'PortalController@Show')->name('admin.portal.show');
        Route::get('/portal/create', 'PortalController@Create')->name('admin.portal.create');
        Route::post('/portal/', 'PortalController@Store')->name('admin.portal.store');
        Route::get('/portal/{slug}/active', 'PortalController@Active')->name('admin.portal.active');
        Route::get('/portal/{slug}/nonactive', 'PortalController@NonActive')->name('admin.portal.nonactive');
        Route::get('/portal/{slug}/edit', 'PortalController@Edit')->name('admin.portal.edit');
        Route::post('/portal/{slug}/update', 'PortalController@Update')->name('admin.portal.update');
        Route::post('/portal/{slug}/delete', 'PortalController@Delete')->name('admin.portal.delete');

        //biro Budaya
        Route::get('/biro/', 'BiroController@Index')->name('admin.biro.index');
        Route::get('/biro/index', 'BiroController@Index')->name('admin.biro.index');
        Route::get('/biro/{slug}/show', 'BiroController@Show')->name('admin.biro.show');
        Route::get('/biro/create', 'BiroController@Create')->name('admin.biro.create');
        Route::post('/biro/', 'BiroController@Store')->name('admin.biro.store');
        Route::get('/biro/{slug}/active', 'BiroController@Active')->name('admin.biro.active');
        Route::get('/biro/{slug}/nonactive', 'BiroController@NonActive')->name('admin.biro.nonactive');
        Route::get('/biro/{slug}/edit', 'BiroController@Edit')->name('admin.biro.edit');
        Route::post('/biro/{slug}/update', 'BiroController@Update')->name('admin.biro.update');
        Route::post('/biro/{slug}/delete', 'BiroController@Delete')->name('admin.biro.delete');
    });
    
});


Route::group(['prefix' => 'id'], function () {
    Route::get('/tentang/sejarah', 'Guest\AboutController@aboutSejarah')->name('id.sejarah');
    Route::get('/tentang/visimisi', 'Guest\AboutController@aboutVisiMisi')->name('id.visi_misi');
    Route::get('/tentang/makna-lambang', 'Guest\AboutController@aboutMaknaLambang')->name('id.makna_lambang');
    Route::get('/tentang/sambutan-rektor', 'Guest\AboutController@aboutRektorUnhi')->name('id.rektor_unhi');
    Route::get('/tentang/pimpinan-unhi', 'Guest\AboutController@pimpinanUnhi')->name('id.pimpinan_unhi');
    Route::get('/tentang/struktur-organisasi-unhi', 'Guest\AboutController@organisasiUnhi')->name('id.organisasi_unhi');

    Route::get('/kemahasiswaan/bem', 'Guest\BemController@bem')->name('id.bem');
    Route::get('/kemahasiswaan/bem/visimisi', 'Guest\BemController@bemVisiMisi')->name('id.bem.visi_misi');
    Route::get('/kemahasiswaan/bem/organisasi', 'Guest\BemController@bemOrganisasi')->name('id.bem.organisasi');

    Route::get('/kemahasiswaan/senat/', 'Guest\SenatController@senatAll')->name('id.senat');
    Route::get('/kemahasiswaan/senat/{slug}', 'Guest\SenatController@senat')->name('id.senat.detail');

    Route::get('/kemahasiswaan/ukm', 'Guest\UkmController@ukm')->name('id.ukm');

    Route::get('/rilisberita', 'Guest\BeritaController@listBerita')->name('id.list_berita');
    Route::get('/berita/detail-berita/{slug}', 'Guest\BeritaController@detailBerita')->name('id.detail_berita');

    Route::get('/list-agenda', 'Guest\AgendaController@listAgenda')->name('id.list_agenda');
    Route::get('/agenda/detail-agenda/{slug}', 'Guest\AgendaController@detailAgenda')->name('id.detail_agenda');

    Route::get('/list-pengumuman', 'Guest\PengumumanController@listPengumuman')->name('id.list_pengumuman');
    Route::get('/pengumuman/detail-pengumuman/{slug}', 'Guest\PengumumanController@detailPengumuman')->name('id.detail_pengumuman');

    Route::get('/list-agama-budaya', 'Guest\BudayaController@listBudaya')->name('id.list_agama_budaya');
    Route::get('/agama-budaya/detail-agama-budaya/{slug}', 'Guest\BudayaController@detailBudaya')->name('id.detail_agama_budaya');

    Route::get('/video/{slug}', 'Guest\VideoController@listVideo')->name('id.list_video');
    Route::get('/list-gallery/{slug}', 'Guest\GaleriController@listGallery')->name('id.list_gallery_latest');

    Route::get('/pendidikan/dokumen-akademik/list-kalender-akademik/', 'Guest\DokumenAkademikController@listKalender')->name('id.list_kalender');
    Route::get('/pendidikan/dokumen-akademik/list-kalender-akademik/{slug}', 'Guest\DokumenAkademikController@showKalender')->name('id.see_kalender_akademik');

    Route::get('/pendidikan/program', 'Guest\ProgramPendidikanController@programPendidikan')->name('id.program_pendidikan');
    Route::get('/prodi/profile/{slug}', 'Guest\ProgramPendidikanController@profil')->name('id.prodi');
    Route::get('/prodi/visi-misi/{slug}', 'Guest\ProgramPendidikanController@visiMisi')->name('id.prodi_visi');
    // Route::get('/prodi/latar-belakang/{slug}', 'Guest\ProgramPendidikanController@latarBelakang')->name('id.prodi_latar');
    Route::get('/prodi/struktur-organisasi/{slug}', 'Guest\ProgramPendidikanController@organisasi')->name('id.prodi_organisasi');
    Route::get('/prodi/dosen/{slug}', 'Guest\ProgramPendidikanController@dosen')->name('id.prodi_dosen');
    Route::get('/prodi/gallery/{slug}', 'Guest\ProgramPendidikanController@gallery')->name('id.prodi_gallery');

    Route::get('/fakultas/profile/{slug}', 'Guest\FakultasController@index')->name('id.fak');
    Route::get('/fakultas/visi-misi/{slug}', 'Guest\FakultasController@visiMisi')->name('id.fak_visi');
    Route::get('/fakultas/struktur-organisasi/{slug}', 'Guest\FakultasController@organisasi')->name('id.fak_organisasi');
    Route::get('/fakultas/gallery/{slug}', 'Guest\FakultasController@gallery')->name('id.fak_gallery');
    Route::get('/fakultas/prodi/{slug}', 'Guest\FakultasController@prodi')->name('id.fak_prodi');

    Route::get('/inbis/latar-belakang', 'Guest\InbisController@latarBelakang')->name('id.inbis.latar_belakang');
    Route::get('/inbis/visi-misi', 'Guest\InbisController@visiMisi')->name('id.inbis.visi_misi');
    Route::get('/inbis/struktur-organisasi', 'Guest\InbisController@strukturOrganisasi')->name('id.inbis.organisasi');
    Route::get('/inbis/pendamping-tenant', 'Guest\InbisController@pendampingTenant')->name('id.inbis.pendamping_tenant');
    Route::get('/inbis/tenant-inwall', 'Guest\InbisController@tenantInwall')->name('id.inbis.tenant_inwall');
    Route::get('/inbis/tenant-outwall', 'Guest\InbisController@tenantOutwall')->name('id.inbis.tenant_outwall');

    Route::get('/peta-kampus', 'Guest\MapsController@petaKampus')->name('id.peta_kampus');

    Route::get('/list-warta-unhi', 'Guest\WartaUnhiController@listWartaUnhi')->name('id.list_warta_unhi');
    Route::get('/list-warta-unhi/{slug}', 'Guest\WartaUnhiController@showWartaUnhi')->name('id.see_warta_unhi');

    Route::get('/biro/{slug}', 'Guest\BiroController@biroPilihan')->name('id.biro');

    Route::get('/search', 'Guest\HomeController@search')->name('id.search');
    Route::get('/ayurweda-news-list', 'Guest\AyurwedaController@listBerita')->name('id.ayurweda_list');
});


Route::group(['prefix' => 'en'], function () {
    Route::get('/tentang/sejarah', 'Guest\AboutController@aboutSejarahEnglsih')->name('en.sejarah');
    Route::get('/tentang/visimisi', 'Guest\AboutController@aboutVisiMisiEnglsih')->name('en.visi_misi');
    Route::get('/tentang/makna-lambang', 'Guest\AboutController@aboutMaknaLambangEnglsih')->name('en.makna_lambang');
    Route::get('/tentang/sambutan-rektor', 'Guest\AboutController@aboutRektorUnhiEnglsih')->name('en.rektor_unhi');
    Route::get('/tentang/pimpinan-unhi', 'Guest\AboutController@pimpinanUnhiEnglsih')->name('en.pimpinan_unhi');
    Route::get('/tentang/struktur-organisasi-unhi', 'Guest\AboutController@organisasiUnhiEnglsih')->name('en.organisasi_unhi');

    Route::get('/kemahasiswaan/bem', 'Guest\BemController@bem')->name('en.bem');
    Route::get('/kemahasiswaan/bem/visimisi', 'Guest\BemController@bemVisiMisi')->name('en.bem.visi_misi');
    Route::get('/kemahasiswaan/bem/organisasi', 'Guest\BemController@bemOrganisasi')->name('en.bem.organisasi');

    Route::get('/kemahasiswaan/senat/', 'Guest\SenatController@senatAll')->name('en.senat');
    Route::get('/kemahasiswaan/senat/{slug}', 'Guest\SenatController@senat')->name('en.senat.detail');

    Route::get('/kemahasiswaan/ukm', 'Guest\UkmController@ukm')->name('en.ukm');

    Route::get('/rilisberita', 'Guest\BeritaController@listBerita')->name('en.list_berita');
    Route::get('/berita/detail-berita/{slug}', 'Guest\BeritaController@detailBerita')->name('en.detail_berita');

    Route::get('/list-agenda', 'Guest\AgendaController@listAgenda')->name('en.list_agenda');
    Route::get('/agenda/detail-agenda/{slug}', 'Guest\AgendaController@detailAgenda')->name('en.detail_agenda');

    Route::get('/list-pengumuman', 'Guest\PengumumanController@listPengumuman')->name('en.list_pengumuman');
    Route::get('/pengumuman/detail-pengumuman/{slug}', 'Guest\PengumumanController@detailPengumuman')->name('en.detail_pengumuman');

    Route::get('/list-agama-budaya', 'Guest\BudayaController@listBudaya')->name('en.list_agama_budaya');
    Route::get('/agama-budaya/detail-agama-budaya/{slug}', 'Guest\BudayaController@detailBudaya')->name('en.detail_agama_budaya');

    Route::get('/video/{slug}', 'Guest\VideoController@listVideo')->name('en.list_video');
    Route::get('/list-gallery/{slug}', 'Guest\GaleriController@listGallery')->name('en.list_gallery_latest');

    Route::get('/pendidikan/dokumen-akademik/list-kalender-akademik/', 'Guest\DokumenAkademikController@listKalender')->name('en.list_kalender');
    Route::get('/pendidikan/dokumen-akademik/list-kalender-akademik/{slug}', 'Guest\DokumenAkademikController@showKalender')->name('en.see_kalender_akademik');

    Route::get('/pendidikan/program', 'Guest\ProgramPendidikanController@programPendidikan')->name('en.program_pendidikan');
    Route::get('/prodi/profile/{slug}', 'Guest\ProgramPendidikanController@profil')->name('en.prodi');
    Route::get('/prodi/visi-misi/{slug}', 'Guest\ProgramPendidikanController@visiMisi')->name('en.prodi_visi');
    // Route::get('/prodi/latar-belakang/{slug}', 'Guest\ProgramPendidikanController@latarBelakang')->name('en.prodi_latar');
    Route::get('/prodi/struktur-organisasi/{slug}', 'Guest\ProgramPendidikanController@organisasi')->name('en.prodi_organisasi');
    Route::get('/prodi/dosen/{slug}', 'Guest\ProgramPendidikanController@dosen')->name('en.prodi_dosen');
    Route::get('/prodi/gallery/{slug}', 'Guest\ProgramPendidikanController@gallery')->name('en.prodi_gallery');

    Route::get('/fakultas/profile/{slug}', 'Guest\FakultasController@index')->name('en.fak');
    Route::get('/fakultas/visi-misi/{slug}', 'Guest\FakultasController@visiMisi')->name('en.fak_visi');
    Route::get('/fakultas/struktur-organisasi/{slug}', 'Guest\FakultasController@organisasi')->name('en.fak_organisasi');
    Route::get('/fakultas/gallery/{slug}', 'Guest\FakultasController@gallery')->name('en.fak_gallery');
    Route::get('/fakultas/prodi/{slug}', 'Guest\FakultasController@prodi')->name('en.fak_prodi');

    Route::get('/inbis/latar-belakang', 'Guest\InbisController@latarBelakang')->name('en.inbis.latar_belakang');
    Route::get('/inbis/visi-misi', 'Guest\InbisController@visiMisi')->name('en.inbis.visi_misi');
    Route::get('/inbis/struktur-organisasi', 'Guest\InbisController@strukturOrganisasi')->name('en.inbis.organisasi');
    Route::get('/inbis/pendamping-tenant', 'Guest\InbisController@pendampingTenant')->name('en.inbis.pendamping_tenant');
    Route::get('/inbis/tenant-inwall', 'Guest\InbisController@tenantInwall')->name('en.inbis.tenant_inwall');
    Route::get('/inbis/tenant-outwall', 'Guest\InbisController@tenantOutwall')->name('en.inbis.tenant_outwall');

    Route::get('/peta-kampus', 'Guest\MapsController@petaKampus')->name('en.peta_kampus');

    Route::get('/list-warta-unhi', 'Guest\WartaUnhiController@listWartaUnhi')->name('en.list_warta_unhi');
    Route::get('/list-warta-unhi/{slug}', 'Guest\WartaUnhiController@showWartaUnhi')->name('en.see_warta_unhi');

    Route::get('/biro/{slug}', 'Guest\BiroController@biroPilihan')->name('en.biro');

    Route::get('/search', 'Guest\HomeController@search')->name('en.search');
    Route::get('/ayurweda-news-list', 'Guest\AyurwedaController@listBerita')->name('en.ayurweda_list');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
