<?php

namespace App\Http\Controllers\Apply;

use App\Common\Model\Adapter\AdapterDevice;
use App\Common\Model\Adapter\HuaweiDevice;
use App\Common\Model\Adapter\XiaomiDevice;
use App\Common\Model\Danli\Danli;
use App\Common\Model\Iterator\UserArray;
use App\Common\Model\Memento\CareTaker;
use App\Common\Model\Memento\Memento;
use App\Common\Model\Zuhe\LeafCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Common\Model\State\Context;
use App\Common\Model\Adapter\Work;
use App\Common\Model\Memento\Originator;
use App\Common\Model\Zuhe\SubCompany;
use App\Common\Model\Zuhe\SubTwo;
use App\Common\Model\Iterator\IteratorA;
use App\Common\Model\Danli\DanliA;
use App\Common\Model\Danli\DanliB;

class ApplyController extends Controller
{

    public function index()
    {
    	$context = new Context();
    	$context->time = 8;
//    	$context->work();
//
//        $xm = new Work(new AdapterDevice());
//        $xm->task();
        echo bindec(decbin(23232323));
    }

    public function memento(){
        $ori = new Originator();
        $ori->setState(1);
        echo $ori->getState();
        $mem = $ori->createMemento();
        $care = new CareTaker();
        $care->setMemento($mem);
        $ori->setState(3);

        $care->setMemento($ori->createMemento());
        echo $ori->getState();
        $mem = $care->getMemento(0);
        $ori->recoveryMemento($mem);
        echo $ori->getState();

        $ori->setState(4);
        $care->setMemento($ori->createMemento());
        echo $ori->getState();

        $mem = $care->getMemento(1);
        $ori->recoveryMemento($mem);
        echo $ori->getState();

    }

    public function zuhe(){

        $root = new SubCompany('总公司');
        $root->add(new LeafCompany("总公司-z1"));
        $root->add(new LeafCompany("总公司-z2"));
        $root->add(new LeafCompany("总公司-z3"));
        $sub = new SubCompany("上海公司");
        $sub->add(new LeafCompany("上海公司-z1"));
        $sub->add(new LeafCompany("上海公司-z2"));
        $sub->add(new LeafCompany("上海公司-z3"));
        $root->add($sub);
        $root->display(1);
    }

    public function iterator(){


        $userArr = new UserArray();
        $userArr->add(1);
        $userArr->add(2);
        $userArr->add(3);
        $userArr->add(4);
        $iter = new IteratorA($userArr);
        echo $iter->current();
        echo $iter->next();
        while($iter->hasNext()){
            echo $iter->next();
        }
    }

    public function danli(){
        $danli = DanliA::getInstance();
        $danli = DanliB::getInstance();
        $danli->set(77);
    }

    public function applyRefund(Request $request){


    }
}