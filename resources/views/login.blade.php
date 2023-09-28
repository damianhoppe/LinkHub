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
        --max-width: 400px;
      }
      form {
        display: flex;
        flex-direction: column;
        align-items: center;
      }
      form > span {
        color: red;
      }
      input[type="submit"] {
        margin-top: 12px;
        width: 248px;
      }
      label {
        margin-top: 8px;
      }
      input {
        width: 240px;
      }
    </style>
  </head>
  <body>
    <div id="container">
      <form action="/login" method="post">
        {{ csrf_field() }}
        <span>{{ isset($error)? $error : '' }}</span>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="{{ isset($username)? $username : '' }}"/>
        <label for="password">Password</label>
        <input type="password" name="password" id="password"/>
        <input type="submit" value="Log in"/>
      </form>
    </div>
  </body>
</html>