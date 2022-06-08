<b>{{ setting('site.title') }} - Контактная форма</b>
<b>Имя:</b> {{ $contact->name }}
<b>Телефон:</b> {{ $contact->phone }}
<b>Сообщение:</b> {{ $contact->message }}
<b>Форма:</b> {{ $contact->type_title }}
@if($product)
<b>Товар:</b> <a href="{{ $product->url }}">{{ $product->name }}</a>
@endif
