<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Niramit:wght@400;500;600&display=swap" rel="stylesheet">
    <title></title>
    <style>
      :root {
        --max-width: 580px;
      }
    </style>
  </head>
  <body>
    <div id="container">
      <header>
          <a href="/">Preview</a>
        <a href="/logout">Logout</a>
        <img src=""/>
        <div>
          <h1 id="title">
            {{ $title }}
          </h1>
          <form action="/admin/settings/title" method="post" class="virtualActionButtons position-relative">
            @csrf
            @method('PUT')
            <input type="text" name="value" value="{{ $title }}" data-on-update-id="title"/>
            <div class="actionButtons">
              <button type="submit" class="round">
                <img src="/icons/feather/edit.svg" />
              </button>
            </div>
          </form>
        </div>
        <div>
          <p id="description">
            {{ $description }}
          </p>
          <form action="/admin/settings/description" method="post" class="virtualActionButtons position-relative">
            @csrf
            @method('PUT')
            <input type="text" name="value" value="{{ $description }}" data-on-update-id="description"/>
            <div class="actionButtons">
              <button type="submit" class="round">
                <img src="/icons/feather/edit.svg" />
              </button>
            </div>
          </form>
        </div>
      </header>
      <main>
        <ul>
          @foreach ($links as $link)
            <li data-id="{{ $link->id }}" data-name="{{ $link->name }}" data-icon="{{ $link->icon }}" data-url="{{ $link->url }}">
              @if (!empty($linkToEdit) && $linkToEdit->id == $link->id)
              <form action="/admin/links/{{ $link->id }}" method="post">
                @csrf
                @method('PUT')
                <label>
                  <span>Name</span>
                  <input type="text" name="name" value="{{ $linkToEdit->name }}"/>
                </label>
                <label>
                  <span>Url</span>
                  <input type="text" name="url" value="{{ $linkToEdit->url }}"/>
                </label>
                <label>
                  <span>Icon</span>
                  <input type="text" name="icon" value="{{ $linkToEdit->icon }}"/>
                </label>
                <input type="submit" value="Save"/>
              </form>
              @else
                <a href="{{ $link->url }}" target="_blank">
                  <img class="icon" src="{{ asset('icons/feather/' . $link->icon) }}"/>
                  <span class="text">{{ $link->name }}</span>
                </a>
              @endif
              <div class="actionButtons">
                <div class="round-b2">
                  <button data-onclick-event="toUpLink">
                    <img src="/icons/feather/chevron-up.svg" />
                  </button>
                  <button data-onclick-event="toDownLink">
                    <img src="/icons/feather/chevron-down.svg" />
                  </button>
                </div>
                @if (!empty($linkToEdit) && $linkToEdit->id == $link->id)
                  <a href="/admin/links">
                @else
                  <a href="/admin/links/{{ $link->id }}/edit">
                @endif
                  <button class="round" data-onclick-event="editLink">
                    <img src="/icons/feather/edit.svg" />
                  </button>
                </a>
                <form action="/admin/links/{{ $link->id }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="round" data-onclick-event="removeLink">
                    <img src="/icons/feather/x.svg" />
                  </button>
                </form>
              </div>
            </li>
          @endforeach
          <div class="line"></div>
          <li>
            <a href="/admin/links/create">
              <img class="icon" src="{{ asset('icons/feather/plus.svg') }}"/>
              <span class="text">Dodaj</span>
            </a>
          </li>
        </ul>
      </main>
      <footer>
        <!-- <a href="#" class="round-icon">
          <img class="icon" src="{{ asset('icons/feather/share-2.svg') }}"/>
        </a> -->
      </footer>
    </div>
  </body>
</html>

<script>

let inputs = document.getElementsByTagName("input");
for (let input of inputs) {
  let id = input.dataset.onUpdateId;
  console.log(input.dataset);
  if(id == null)
    continue;
  let element = document.getElementById(id);
  if(element == null)
    continue;
  let updateInnerText = function() {
    element.innerText = input.value;
  };
  input.addEventListener('input', updateInnerText);
}

let buttons = document.getElementsByTagName("button");
for (let button of buttons) {
  let event = button.dataset.onclickEvent;
  if(event == null)
    continue;
  switch(event) {
    case "toUpLink":
      button.addEventListener('click', function(event) {
        let li = event.target.closest('li');
        let id = li.dataset.id;
        window.location.href = "?toUpLink=" + id;
      });
      break;
    case "toDownLink":
      button.addEventListener('click', function(event) {
        let li = event.target.closest('li');
        let id = li.dataset.id;
        window.location.href = "?toDownLink=" + id;
      });
      break;
  }
}

function newLink(event) {
  let li = event.target.closest('li');
  let name = window.prompt("Name:", "");
  if(name == null)
    return;
  let url = window.prompt("Url:", "");
  if(url == null)
    return;
  let icon = window.prompt("Icon:", "");
  if(icon == null)
    return;
  window.location.href = "?newLink=true&name=" + name + "&url=" + url + "&icon=" + icon;
}

if(window.location.href.indexOf('?') >= 0)
  window.history.replaceState('page2', 'Title', '{{ route('admin.links.index') }}');
</script>