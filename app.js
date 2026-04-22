function addToCart(productId) {
  fetch("../api/cart_api.php", {
    method: "POST",
    headers: {"Content-Type": "application/x-www-form-urlencoded"},
    body: "action=add&product_id=" + productId + "&quantity=1"
  })
  .then(res => res.json())
  .then(data => {
    document.getElementById("cart-count").innerText = data.count;
    alert("Added to cart 🔥");
  });
}
function updateQty(id, change) {
  fetch("../api/cart_update.php", {
    method: "POST",
    headers: {"Content-Type": "application/x-www-form-urlencoded"},
    body: "id=" + id + "&change=" + change
  })
  .then(res => res.json())
  .then(data => {
    location.reload(); // simple refresh (can optimize later)
  });
}