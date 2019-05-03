
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Restaurant</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">



    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <style>
        html,
body {
  height: 100%;
}

body {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}
.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}

    </style>

  </head>
  <body class="text-center">

    <div class="form-signin">
        <div class="row">

        </div>
        </br>
        </br>
        <div class="row">
            <div class="col">
                <button class="btn btn-info btn-block" onclick="home()"><span class="fas fa-home"></span></button>
            </div>
            <div class="col">
                <button class="btn btn-info btn-block" onclick="order()">Order</button>
            </div>
            <div class="col">
                <button class="btn btn-info btn-block">MyOrder</button>
            </div>
            <div class="col">
                </br>
                <button class="btn btn-danger btn-block" onclick="logout(event)">Logout</button>
            </div>
        </div>
        <p class="mt-5 mb-3 text-muted">&copy; 2019|gindash.com</p>

    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script>

        let logout = (e) => {
            e.preventDefault();

            axios.get('http://localhost:8000/api/logout?api_token='+sessionStorage.getItem("api_token"))
            .then(function (response) {
                sessionStorage.clear();
                window.location.href = "http://localhost:8000";
            })
            .catch(function (error) {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: error.response.data[0],
                })
            });
        }

        let order = () => {
            window.location.href = "http://localhost:8000/order";
        }

        let home = () => {
            window.location.href = "http://localhost:8000/home";
        }
    </script>

</body>
</html>
