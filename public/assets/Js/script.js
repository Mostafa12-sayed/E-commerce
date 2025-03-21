// document
//     .getElementById("confirm-order")
//     .addEventListener("click", confirmOrder);

// $("#start-new-order").on("click", startNewOrder);
// var productList = localStorage.getItem("products");
// if (productList === null) {
//     displayEmptyMessage();
//     $("#order-summary").hide();
// } else {
//     displayProductList();
// }
// onload = updateButtonAddToCart();
// function displayEmptyMessage() {
//     var emptyMessage = $("#cart-empty");
//     emptyMessage.show();
//     $("#cart-items").hide();
//     $("#order-summary").hide();
//     $("#cart-count").text(0);
// }

// function displayProductList() {
//     var products = localStorage.getItem("products");
//     var productList = JSON.parse(products);
//     var cartItems = document.getElementById("cart-items");
//     var cartItemsList = "";
//     var totalPrice = 0;
//     for (var i = 0; i < productList.length; i++) {
//         var product = productList[i];
//         console.log(product.price.toPrecision(3));
//         cartItemsList += `<div class="row cart-item">
//     <div class="col-10">
//       <div class="d-flex flex-column">
//         <h3 class="text-start name-item">${product.name}</h3>
//         <div
//           class="d.flex justify-content-between text-start mt-2 align-items-center"
//         >
//           <span class="counter">${product.quantity}x</span>
//           <span class="ms-4">@</span>
//           <span class="price">$${product.price.toPrecision(3)}</span>
//           <span class="total-price-item ms-2">$${(
//               product.price * product.quantity
//           ).toPrecision(3)}</span>
//         </div>
//       </div>
//     </div>
//     <div class="col-2 remove">
//         <svg
//           xmlns="http://www.w3.org/2000/svg"
//           width="10"
//           height="10"
//           fill="none"
//           viewBox="0 0 10 10"
//           onclick="removeFromCart(${product.id})"
//         >
//           <path
//             fill="#CAAFA7"
//             d="M8.375 9.375 5 6 1.625 9.375l-1-1L4 5 .625 1.625l1-1L5 4 8.375.625l1 1L6 5l3.375 3.375-1 1Z"
//           />
//         </svg>

//     </div>
//     <hr class="mt-2 mb-2 text-center mx-auto" />
//     </div>`;
//         totalPrice += product.price * product.quantity;
//     }
//     cartItems.innerHTML = cartItemsList;
//     document.getElementById(
//         "total-price-value"
//     ).innerText = `$${totalPrice.toPrecision(4)}`;
//     document.getElementById("order-summary").style.display = "block";
//     document.getElementById("cart-count").innerText = productList.length;
//     document.getElementById("cart-items").style.display = "block";
// }

// function addToCart(product) {
//     var id = product;
//     var productList = JSON.parse(localStorage.getItem("products"));
//     var item_name = document.getElementById(`item_name_${id}`);
//     var item_price = document.getElementById(`item_price_${id}`);
//     var found = false;
//     var newProduct = {
//         id: id,
//         name: item_name.innerHTML,
//         price: parseFloat(item_price.innerHTML.replace("$", "")),
//         quantity: 1.0,
//     };
//     if (productList === null) {
//         productList = [];
//         productList.push(newProduct);
//         localStorage.setItem("products", JSON.stringify(productList));
//         document.getElementById("cart-empty").style.display = "none";
//         displayProductList();
//     } else {
//         for (var i = 0; i < productList.length; i++) {
//             if (productList[i].id === id) {
//                 found = true;
//                 break;
//             }
//         }
//         if (found) {
//             return;
//         } else {
//             productList.push(newProduct);
//             localStorage.setItem("products", JSON.stringify(productList));
//             pushtoCart(newProduct);
//         }
//     }
//     updateButtonAddToCart();
// }

// function pushtoCart(prodcut) {
//     document.getElementById(
//         "cart-items"
//     ).innerHTML = `<div class="row cart-item">
//   <div class="col-10">
//     <div class="d-flex flex-column">
//       <h3 class="text-start name-item">${prodcut.name}</h3>
//       <div
//         class="d.flex justify-content-between text-start mt-2 align-items-center"
//       >
//         <span class="counter">${prodcut.quantity}x</span>
//         <span class="ms-4">@</span>
//         <span class="price">$${prodcut.price}</span>
//         <span class="total-price-item ms-2">$${
//             prodcut.price * prodcut.quantity
//         }</span>
//       </div>
//     </div>
//   </div>
//   <div class="col-2 remove">
//       <svg
//         xmlns="http://www.w3.org/2000/svg"
//         width="10"
//         height="10"
//         fill="none"
//         viewBox="0 0 10 10"
//         onclick="removeFromCart(${prodcut.id})"
//       >
//         <path
//           fill="#CAAFA7"
//           d="M8.375 9.375 5 6 1.625 9.375l-1-1L4 5 .625 1.625l1-1L5 4 8.375.625l1 1L6 5l3.375 3.375-1 1Z"
//         />
//       </svg>

//   </div>
//   <hr class="mt-2 mb-2 text-center mx-auto" />
//   </div>`;
//     displayProductList();
// }

// function removeFromCart(id) {
//     var productList = JSON.parse(localStorage.getItem("products"));
//     if (productList === null) {
//         return;
//     } else {
//         for (var i = 0; i < productList.length; i++) {
//             if (productList[i].id === id) {
//                 productList.splice(i, 1);
//                 updatedBtn(true, id);
//                 break;
//             }
//         }
//         if (productList.length === 0) {
//             displayEmptyMessage();
//             localStorage.removeItem("products");
//         } else {
//             localStorage.setItem("products", JSON.stringify(productList));
//             displayProductList();
//         }
//     }
// }
// function updateQuantityToPlus(id) {
//     var productList = JSON.parse(localStorage.getItem("products"));
//     for (var i = 0; i < productList.length; i++) {
//         if (productList[i].id === id) {
//             productList[i].quantity += 1;
//             break;
//         }
//     }
//     localStorage.setItem("products", JSON.stringify(productList));
//     displayProductList();
//     updateButtonAddToCart();
// }
// function updateQuantityToMinus(id) {
//     var productList = JSON.parse(localStorage.getItem("products"));
//     for (var i = 0; i < productList.length; i++) {
//         if (productList[i].id === id) {
//             if (productList[i].quantity === 1) {
//                 return;
//             } else {
//                 productList[i].quantity -= 1;
//                 break;
//             }
//         }
//     }
//     localStorage.setItem("products", JSON.stringify(productList));
//     displayProductList();
//     updateButtonAddToCart();
// }

// function updateButtonAddToCart() {
//     if (localStorage.getItem("products")) {
//         var productList = JSON.parse(localStorage.getItem("products"));
//         for (var i = 0; i < productList.length; i++) {
//             document.getElementById(
//                 `btn-add-to-cart-${productList[i].id}`
//             ).innerHTML = `<div
//                 class="overlay-add d-flex justify-content-between align-items-center"
//               >
//                 <svg
//                   xmlns="http://www.w3.org/2000/svg"
//                   width="10"
//                   height="2"
//                   fill="none"
//                   viewBox="0 0 10 2"
//                   onclick="updateQuantityToMinus(${productList[i].id})"
//                 >
//                   <path fill="#fff" d="M0 .375h10v1.25H0V.375Z" />
//                 </svg>
//                 <span class="quantity">${productList[i].quantity}</span>
//                 <svg
//                   xmlns="http://www.w3.org/2000/svg"
//                   width="10"
//                   height="10"
//                   fill="none"
//                   viewBox="0 0 10 10"
//                   onclick="updateQuantityToPlus(${productList[i].id})"
//                 >
//                   <path
//                     fill="#fff"
//                     d="M10 4.375H5.625V0h-1.25v4.375H0v1.25h4.375V10h1.25V5.625H10v-1.25Z"
//                   />
//                 </svg>
//               </div>`;
//             document.getElementById(
//                 `product-image-${productList[i].id}`
//             ).style.border = "2px solid hsl(14, 86%, 42%)";
//         }
//     }
// }

// function updatedBtn(flag, id) {
//     if (flag) {
//         document.getElementById(`product-image-${id}`).style.border = "none";
//         document.getElementById(`btn-add-to-cart-${id}`).innerHTML = `<button
//                   class="btn btn-primary overlay-add-to-cart"
//                   id="add-to-cart-${id}"
//                   onclick="addToCart(${id})"
//                 >
//                   <svg
//                     xmlns="http://www.w3.org/2000/svg"
//                     width="18"
//                     height="20"
//                     fill="none"
//                     viewBox="0 0 21 20"
//                   >
//                     <g fill="#C73B0F" clip-path="url(#a)">
//                       <path
//                         d="M6.583 18.75a1.25 1.25 0 1 0 0-2.5 1.25 1.25 0 0 0 0 2.5ZM15.334 18.75a1.25 1.25 0 1 0 0-2.5 1.25 1.25 0 0 0 0 2.5ZM3.446 1.752a.625.625 0 0 0-.613-.502h-2.5V2.5h1.988l2.4 11.998a.625.625 0 0 0 .612.502h11.25v-1.25H5.847l-.5-2.5h11.238a.625.625 0 0 0 .61-.49l1.417-6.385h-1.28L16.083 10H5.096l-1.65-8.248Z"
//                       />
//                       <path
//                         d="M11.584 3.75v-2.5h-1.25v2.5h-2.5V5h2.5v2.5h1.25V5h2.5V3.75h-2.5Z"
//                       />
//                     </g>
//                     <defs>
//                       <clipPath id="a">
//                         <path fill="#fff" d="M.333 0h20v20h-20z" />
//                       </clipPath>
//                     </defs>
//                   </svg>

//                   Add to cart
//                 </button>`;
//     }
// }

// /******************************confirm order ********************* */

// function confirmOrder() {
//     $("#exampleModalCenter").modal("show");
//     var productList = JSON.parse(localStorage.getItem("products"));
//     var totalPrice = 0;
//     $("#items-order").children().remove();
//     for (var i = 0; i < productList.length; i++) {
//         var product = productList[i];
//         totalPrice =
//             totalPrice + productList[i].price * productList[i].quantity;
//         $("#items-order").append(`
//       <div class="row">
//           <div class="col-3 col-sm-2" style="height: 60px">
//             <img
//               src="./Images/image-${product.name
//                   .replace(" ", "-")
//                   .toLowerCase()}-thumbnail.jpg"
//               alt=""
//               id="item-image"
//               class="rounded"
//               height="100%"
//               width="50px"
//             />
//           </div>
//           <div
//             class="col-9 col-md-10 col-sm-10 d-flex flex-row justify-content-between align-items-start"
//           >
//             <div
//               class="d-flex flex-column justify-content-between align-items-start"
//             >
//               <span class="name-item">${product.name}</span>
//               <div
//                 class="d.flex justify-content-between text-start mt-2 align-items-center"
//               >
//                 <span class="counter">${product.quantity}x</span>
//                 <span class="ms-2 price">@</span>
//                 <span class="price">$${product.price.toPrecision(3)}</span>
//               </div>
//             </div>
//             <div
//               class="d-flex flex-column justify-content-center align-items-stratch"
//               style="height: 50px"
//             >
//               <strong class="total-price-item-order">$${(
//                   product.price * product.quantity
//               ).toPrecision(3)}</strong>
//             </div>
//           </div>

//           <hr class="mt-2 mb-2" />
//         </div>`);
//     }
//     $("#total-price-order").text(`$${totalPrice.toPrecision(4)}`);
// }

// window.addEventListener("resize", function () {
//     // Check if screen size is less than or equal to 375px
//     var cartItems = document.getElementsByClassName("product");
//     if ($(window).width() <= 375 || $(window).width() <= 768) {
//         for (var i = 0; i <= cartItems.length; i++) {
//             var img = new String($(`#product-image-${i}`).attr("src"));
//             img = img.replace("-desktop", "-mobile");
//             $(`#product-image-${i}`).attr("src", img);
//         }
//     } else if ($(window).width() > 768) {
//         for (var i = 0; i <= cartItems.length; i++) {
//             var img = new String($(`#product-image-${i}`).attr("src"));
//             img = img.replace("-mobile", "-desktop");
//             $(`#product-image-${i}`).attr("src", img);
//             console.log(img);
//         }
//     }
// });

// function startNewOrder() {
//     localStorage.removeItem("products");
//     displayEmptyMessage();
//     $("#order-summary").hide();
//     $("#cart-items").hide();
//     $("#cart-count").text(0);
//     $("#exampleModalCenter").modal("hide");
//     location.reload();
// }

// console.log();

// document.querySelectorAll(".dropdown-toggle").forEach((item) => {
//     item.addEventListener("click", (event) => {
//         if (event.target.classList.contains("dropdown-toggle")) {
//             event.target.classList.toggle("toggle-change");
//         } else if (
//             event.target.parentElement.classList.contains("dropdown-toggle")
//         ) {
//             event.target.parentElement.classList.toggle("toggle-change");
//         }
//     });
// });
