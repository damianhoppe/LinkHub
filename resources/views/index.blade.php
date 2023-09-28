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
        <img src=""/>
        <h1>{{ $title }}</h1>
        <p>{{ $description }}</p>
      </header>
      <main>
        <ul>
          @foreach ($links as $link)
            <li>
              <a href="{{ $link->url }}" target="_blank">
                <img class="icon" src="{{ asset('icons/feather/' . $link->icon) }}"/>
                <span class="text">{{ $link->name }}</span>
              </a>
            </li>
          @endforeach
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