<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\LinkItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Contact;
use App\Category;
use App\Page;
use App\Product;
use App\Helpers\Helper;
use App\InstallmentPayment;
use App\Mail\ContactMail;
use App\Mail\InstallmentPaymentAdminMail;
use App\Mail\InstallmentPaymentClientMail;
use App\Mail\UserRegisteredMail;
use App\Models\Cv;
use App\Services\TelegramService;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    /**
     * Show contacts page
     */
    public function index()
    {
        $locale = app()->getLocale();
        $page = Page::where('slug', 'cvs')->withTranslation($locale)->firstOrFail();
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        return view('cvs.index', compact('breadcrumbs', 'page'));
    }

    public function store(Request $request)
    {
        // $captchaKey = $request->input('captcha_key', '');
        $data = $request->validate([
            // 'captcha_key' => 'required',
            // 'captcha' => 'required|captcha_api:' . $captchaKey . ',flat',
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'message' => '',
            'file' => 'required|file|max:3072|mimes:pdf,docx',
        ]);

        $telegram_chat_id = config('services.telegram.chat_id');

        $filePath = Storage::putFile('cvs', $data['file']);
        $data['file'] = $filePath;


        // save to database
        $cv = Cv::create($data);

        // send telegram
        $telegramMessage = view('telegram.admin.cv', compact('cv'))->render();
        $telegramService = new TelegramService();
        $telegramService->sendMessage($telegram_chat_id, $telegramMessage, 'HTML');
        $telegramService->sendDocument($telegram_chat_id, Storage::path($cv->file));

        // send email
        // Mail::to(setting('contact.email'))->send(new ContactMail($contact));

        // return redirect()->route('home', ['#contact-form'])->withSuccess(__('home.contact_message_success'));

        $data = [
            'message' => __('main.form.cv_form_success'),
        ];

        return response()->json($data);
    }

}
