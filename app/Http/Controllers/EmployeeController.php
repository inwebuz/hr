<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Employee;
use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Page;
use App\Product;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $page = Page::where('slug', 'employees')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        $employees = Employee::active()->orderBy('order')->withTranslation($locale)->get();
        return view('employees.index', compact('page', 'breadcrumbs', 'employees'));
    }

    public function show(Request $request, Employee $employee)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $employee->load('translations');

        $otherEmployeesText = Helper::staticText('other_consultants', 300);
        $otherEmployees = Employee::active()->where('id', '!=', $employee->id)->inRandomOrder()->withTranslation($locale)->take(3)->get();

        $page = Page::where('slug', 'employees')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // $breadcrumbs->addItem(new LinkItem($employee->full_name, $employee->url, LinkItem::STATUS_INACTIVE));

        return view('employees.show', compact('page', 'breadcrumbs', 'employee', 'otherEmployeesText', 'otherEmployees'));
    }

}
