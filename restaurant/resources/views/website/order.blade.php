
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
.products p:hover {
    font-weight: bold;
}
.rmv:hover {
    font-weight: bolder;
}
    </style>

  </head>
  <body class="text-center">

    <div class="form-signin">

        <div class="row formorder">
            <div class="col-12">
                <input type="text" name="table_no" class="form-control" placeholder="Table No.">
            </div>
            </br>
            <div class="col-12 items">
                </br>
                <h3 class="text-left">Items: </h3>
            </div>
            <div class="col-12">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Menu
                            </button>
                        </h2>
                        </div>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="row text-left products">

                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                </br>
            </div>
            <div class="col-12">
                <button class="btn btn-info btn-block" onclick="proccess(event)">Process</button>
            </div>
        </div>
        </br>
        </br>
        <div class="row navuser">
        </div>
        <p class="mt-5 mb-3 text-muted">&copy; 2019|gindash.com</p>

    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="http://localhost:8000/js/navuser.js"></script>


    <script>

        let setItem = (id, name) => {
            console.log(name)
            $('#collapseOne').collapse('hide')
            $('.items').after('<div class="form-group col-12">\
                    <div class="input-group">\
                    <input type="text" name="product_name[]" class="form-control" value="'+name+'" readonly>\
                    <div class="input-group-prepend">\
                    <span class="input-group-text rmv" onclick="remove(this)" style="cursor:pointer;">x</span>\
                    </div>\
                    <input type="hidden" name="items[]" class="form-control" value="'+id+'">\
                </div>')
        }

        let remove = (e) => {
            $(e).closest('.form-group').remove()
        }

        let getProductReady = () => {
            axios.get('http://localhost:8000/api/products-ready?api_token='+sessionStorage.getItem("api_token"))
            .then(function (response) {

                let object = response.data;
                for (const key in object) {
                    if (object.hasOwnProperty(key)) {

                        $('.products').append('<div class="col-12"><p onclick="setItem(\''+object[key]._id+'\', \''+object[key].name+'\')" style="padding:7px 0px; cursor:pointer;">'+object[key].name+' (Rp.'+new Intl.NumberFormat(['ban', 'id']).format(object[key].price)+')</p></div>')
                    }
                }

            })
            .catch(function (error) {
                console.log(error.response.data)
            });
        }

        let proccess = (e) => {
            e.preventDefault()

            let input = $('.formorder :input').serialize();
            axios.post('http://localhost:8000/api/sales-order', input, {
                headers: {'Authorization': sessionStorage.getItem("api_token")}
            })
            .then(function (response) {
                window.location.href = "http://localhost:8000/home";
            })
            .catch(function (error) {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: error.response.data[0],
                })
            });
        }

        getProductReady()
    </script>

</body>
</html>
