<?php

namespace Src\Http\Controllers;
use Src\Core\View;
use Src\Models\Member;

class MemberController
{
    public function index()
    {
        $members = Member::all();

        echo  View::render('members-index', [
            'members' => $members,
        ]);
    }

    public function create()
    {
        echo  View::render('members-create');
    }

    public function store()
    {
        $requestParams = $_POST;

        Member::store($requestParams);

        header('Location: /members');

        exit;
    }
}