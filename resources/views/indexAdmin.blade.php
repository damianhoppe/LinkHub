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
        @if($admin)
          <a href="/logout">Logout</a>
        @endif
        <img src=""/>
        <div>
          <h1 id="title">
            {{ $title }}
          </h1>
          <div class="actionButtons">
            <button class="round" data-onclick-event="edit" data-param="title">
              <img src="/icons/feather/edit.svg" />
            </button>
          </div>
        </div>
        <div>
          <p id="description">
            {{ $description }}
          </p>
          <div class="actionButtons">
            <button class="round" data-onclick-event="edit" data-param="description">
              <img src="/icons/feather/edit.svg" />
            </button>
          </div>
        </div>
      </header>
      <main>
        <ul>
          @foreach ($links as $link)
            <li data-id="{{ $link->id }}" data-name="{{ $link->name }}" data-icon="{{ $link->icon }}" data-url="{{ $link->url }}">
              <a href="{{ $link->url }}" target="_blank">
                <img class="icon" src="{{ asset('icons/feather/' . $link->icon) }}"/>
                <span class="text">{{ $link->name }}</span>
              </a>
              <div class="actionButtons">
                <div class="round-b2">
                  <button data-onclick-event="toUpLink">
                    <img src="/icons/feather/chevron-up.svg" />
                  </button>
                  <button data-onclick-event="toDownLink">
                    <img src="/icons/feather/chevron-down.svg" />
                  </button>
                </div>
                <button class="round" data-onclick-event="editLink">
                  <img src="/icons/feather/edit.svg" />
                </button>
                <button class="round" data-onclick-event="removeLink">
                  <img src="/icons/feather/x.svg" />
                </button>
              </div>
            </li>
          @endforeach
          <div class="line"></div>
          <li onclick="newLink(event)">
            <a href="#">
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
let buttons = document.getElementsByTagName("button");
for (let button of buttons) {
  let event = button.dataset.onclickEvent;
  if(event == null)
    continue;
  switch(event) {
    case "edit":
      button.addEventListener('click', function(event) {
        let param = event.target.dataset.param;
        let valueElement = document.getElementById(event.target.dataset.param);
        if(valueElement == null)
          return;
        let value = valueElement.innerText;
        let newValue = window.prompt("", value);
        if(newValue != null) {
          window.location.href = "?edit=" + param + "&value=" + newValue;
        }
      });
      break;
    case "editLink":
      button.addEventListener('click', function(event) {
        let li = event.target.closest('li');
        let id = li.dataset.id;
        let name = window.prompt("", li.dataset.name);
        if(name == null)
          return;
        let url = window.prompt("", li.dataset.url);
        if(url == null)
          return;
        let icon = window.prompt("", li.dataset.icon);
        if(icon == null)
          return;
        window.location.href = "?editLink=" + id + "&name=" + name + "&url=" + url + "&icon=" + icon;
      });
      break;
    case "removeLink":
      button.addEventListener('click', function(event) {
        let li = event.target.closest('li');
        let id = li.dataset.id;
        window.location.href = "?removeLink=" + id;
      });
      break;
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

window.history.replaceState('page2', 'Title', '/');
</script>