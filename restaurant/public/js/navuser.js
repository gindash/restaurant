const baseUrl = "http://"+window.location.href.split('/')[2]

if (sessionStorage.getItem("api_token") == null){
    window.location.href = baseUrl+"";
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


let logout = (e) => {
    e.preventDefault();


    axios.get(baseUrl+'/api/logout?api_token='+sessionStorage.getItem("api_token"))
    .then(function (response) {
        sessionStorage.clear();
        window.location.href = baseUrl+"";
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
    window.location.href = baseUrl+"/order";
}

let home = () => {
    window.location.href = baseUrl+"/home";
}

let myorder = () => {
    window.location.href = baseUrl+"/myorder";
}
