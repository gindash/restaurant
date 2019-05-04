if (sessionStorage.getItem("api_token") == null){
    window.location.href = "http://localhost:8000";
}


var routes = sessionStorage.getItem("routes").split(",")

var found = routes.find(function(element) {
    return element == 'active-sales-orders.index'
});
if (found == 'active-sales-orders.index'){
    $('.navuser').append('<div class="col">\
                <button class="btn btn-info btn-block" onclick="home()"><span class="fas fa-home"></span></button>\
            </div>')
}

var found = routes.find(function(element) {
    return element == 'sales-order.store'
});
if (found == 'sales-order.store'){
    $('.navuser').append('<div class="col">\
                <button class="btn btn-info btn-block" onclick="order()">Order</button>\
            </div>')
}

var found = routes.find(function(element) {
    return element == 'my-sales-orders.index'
});
if (found == 'my-sales-orders.index'){
    $('.navuser').append('<div class="col">\
                <button class="btn btn-info btn-block" onclick="myorder()">MyOrder</button>\
            </div>')
}

var found = routes.find(function(element) {
    return element == 'sales-order.setstatus'
});
if (found == 'sales-order.setstatus'){
    $('.formorder').append('<div class="col-12">\
                </br>\
                <button class="btn btn-info btn-block" id="pay"><span class="fab fa-amazon-pay fa-3x"></span></button>\
            </div>')
}

$('.navuser').append('<div class="col-12">\
                </br>\
                <button class="btn btn-danger btn-block" onclick="logout(event)">Logout</button>\
            </div>')


console.log(found)

for (const key in routes) {
    if (routes.hasOwnProperty(key)) {
        console.log(routes[key])

    }
}

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

let myorder = () => {
    window.location.href = "http://localhost:8000/myorder";
}
