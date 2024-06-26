$(document).ready(function () {
  _apiPost("test/index", {
    key: "value",
  }).then((data) => {
    if (data) {
      console.log(data);
    }
  });
});
