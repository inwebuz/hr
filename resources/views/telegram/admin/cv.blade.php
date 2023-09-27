<b>{{ setting('site.title') }} - Резюме</b>
<b>Имя:</b> {{ $cv->name }}
<b>Телефон:</b> {{ $cv->phone_number }}
<b>E-mail:</b> {{ $cv->email }}
<b>Откуда вы о нас узнали?:</b> {{ $cv->source }}
<b>Сообщение:</b> {{ $cv->message }}
@if($vacancy) <b>Вакансия:</b> {{ $vacancy->name }} @endif
