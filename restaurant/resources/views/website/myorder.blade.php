
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
.table-fixed{
  width: 100%;
  background-color: #f3f3f3;
  tbody{
    height:200px;
    overflow-y:auto;
    width: 100%;
    }
  thead,tbody,tr,td,th{
    display:block;
  }
  tbody{
    td{
      float:left;
    }
  }
  thead {
    tr{
      th{
        float:left;
       background-color: #f39c12;
       border-color:#e67e22;
      }
    }
  }
}

i:hover {
    font-size: 15px;
}

    </style>

  </head>
  <body class="text-center">

    <div class="form-signin">
        <h3>My Order</h3>
        <div class="row">
            <div class="col-12">
                <table class="table table-fixed table-striped" width="100%">
                    <thead>
                        <tr>
                            <td>Table</td>
                            <td>Order</td>
                            <td>Time</td>
                            <td>#</td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        </br>
        <div class="row navuser">
        </div>
        <p class="mt-5 mb-3 text-muted">&copy; 2019|gindash.com</p>

    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="{{asset('/js/navuser.js')}}"></script>


    <script>

        let status = {
            'active': '<i class="fas fa-cog"></i>',
            'completed': '<i class="fas fa-check"></i>',
            'canceled': '<i class="fas fa-times"></i>',
        }

        let getMySalesOrders = () => {
            axios.get(baseUrl+'/api/my-sales-orders?api_token='+sessionStorage.getItem("api_token"))
            .then(function (response) {

                let object = response.data;
                for (const key in object) {
                    if (object.hasOwnProperty(key)) {

                        var date = new Date(object[key].created_at)
                        // console.log(object[key].created_by)

                        $('tbody').append('<tr>\
                            <td>'+object[key].table_no+'</td>\
                            <td>'+object[key].order_number+'</td>\
                            <td>'+date.getHours() + ':' + date.getMinutes()+'</td>\
                            <td>'+status[object[key].status]+'</td>\
                        </tr>')
                    }
                }

            })
            .catch(function (error) {
                console.log(error)
            });
        }

        // let showOrder = (id) => {

        //     window.location.href = baseUrl+"/order-detail/"+id;
        // }

        getMySalesOrders()
    </script>

</body>
</html>
