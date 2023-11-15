<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\LinkRepository;
use App\Http\Requests\StoreLinkRequest;
use App\Repositories\SettingRepository;
use App\Http\Requests\UpdateLinkRequest;

class LinkController extends Controller {

    private LinkRepository $linkRepository;
    private SettingRepository $settingRepository;

    public function __construct(LinkRepository $linkRepository, SettingRepository $settingRepository) {
        $this->linkRepository = $linkRepository;
        $this->settingRepository = $settingRepository;
    }

    function processRequestAction(Request $request) {
        $data = $request->input("toUpLink", null);
        if($data != null) {
            $id = $data;
            DB::transaction(function () use ($id) {
                $orderPosition = DB::select('SELECT order_position FROM links WHERE id=?', [$id])[0]->order_position;
                $newPos = DB::select('SELECT MAX(order_position) AS max FROM links WHERE order_position < ?', [$orderPosition])[0]->max;
                if($newPos == null)
                    return;
                $links = DB::select('SELECT * FROM links WHERE order_position=?', [$newPos]);
                if(sizeof($links) == 0)
                    return;
                foreach($links as $link) {
                    DB::update('UPDATE links SET order_position=? WHERE id=?', [$orderPosition, $link->id]);
                }
                DB::update('UPDATE links SET order_position=? WHERE id=?', [$newPos, $id]);
            });
            return;
        }
        $data = $request->input("toDownLink", null);
        if($data != null) {
            $id = $data;
            DB::transaction(function () use ($id) {
                $orderPosition = DB::select('SELECT order_position FROM links WHERE id=?', [$id])[0]->order_position;
                $newPos = DB::select('SELECT MIN(order_position) AS min FROM links WHERE order_position > ?', [$orderPosition])[0]->min;
                if($newPos == null)
                    return;
                $links = DB::select('SELECT * FROM links WHERE order_position=?', [$newPos]);
                if(sizeof($links) == 0)
                    return;
                foreach($links as $link) {
                    DB::update('UPDATE links SET order_position=? WHERE id=?', [$orderPosition, $link->id]);
                }
                DB::update('UPDATE links SET order_position=? WHERE id=?', [$newPos, $id]);
            });
            return;
        }
    }

    public function index(Request $request) {
        $this->processRequestAction($request);
        return view('indexAdmin', [
            'links' => $this->linkRepository->getAll(),
            'title' => $this->settingRepository->find('title'),
            'description' => $this->settingRepository->find('description'),
        ]);
    }

    public function create() {
        return view('createLink', [
            'links' => $this->linkRepository->getAll(),
            'title' => $this->settingRepository->find('title'),
            'description' => $this->settingRepository->find('description'),
        ]);
    }

    public function store(StoreLinkRequest $request) {
        $link = new Link();
        $link->name = $request->input('name');
        $link->url = $request->input('url');
        $link->icon = $request->input('icon');
        $link->order_position = DB::select('SELECT MAX(order_position) as max FROM links')[0]->max + 1;
        $link->save();
        return redirect()->route('admin.links.index');
    }

    public function edit(Link $link) {
        return view('indexAdmin', [
            'links' => $this->linkRepository->getAll(),
            'title' => $this->settingRepository->find('title'),
            'description' => $this->settingRepository->find('description'),
            'linkToEdit' => $link,
        ]);
    }

    public function update(UpdateLinkRequest $request, Link $link) {
        $link->name = $request->input('name');
        $link->url = $request->input('url');
        $link->icon = $request->input('icon');
        $link->save();
        return redirect()->route('admin.links.index');
    }

    public function destroy(Link $link)
    {
        $link->delete();
        return redirect()->route('admin.links.index');
    }
}
