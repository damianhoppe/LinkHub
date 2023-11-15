<?php

namespace App\Http\Controllers;

use App\Auth;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\LinkRepository;
use App\Http\Requests\StoreLinkRequest;
use App\Repositories\SettingRepository;
use App\Http\Requests\UpdateLinkRequest;

class HomeController extends Controller {

    private LinkRepository $linkRepository;
    private SettingRepository $settingRepository;

    public function __construct(LinkRepository $linkRepository, SettingRepository $settingRepository) {
        $this->linkRepository = $linkRepository;
        $this->settingRepository = $settingRepository;
    }

    function index(Request $request) {
        return view('index', [
            'links' => $this->linkRepository->getAll(),
            'title' => $this->settingRepository->find('title'),
            'description' => $this->settingRepository->find('description'),
            'isLogged' => Auth::isLogged($request),
        ]);
    }
}