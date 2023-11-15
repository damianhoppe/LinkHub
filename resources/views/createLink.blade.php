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
        <a href="/logout">Logout</a>
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
          <form action="/admin/links" method="post">
            @csrf
            <label>
                  <span>Name</span>
                  <input type="text" name="name"/>
                </label>
                <label>
                  <span>Url</span>
                  <input type="text" name="url"/>
                </label>
                <label>
                  <span>Icon</span>
                  <input type="text" name="icon"/>
                </label>
                <input type="submit" value="Add"/>
          </form>
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