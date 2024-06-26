function _apiGet(path, params) {
  params["method"] = "GET";
  return fetch(`/api/${path}`, {
    method: "POST",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "application/json",
    },
    body: JSON.stringify(params),
  }).then((response) => {
    if (response.ok) return response.json();
    return libError(response);
  });
}

function _apiPost(path, params) {
  params["method"] = "POST";
  return fetch(`/api/${path}`, {
    method: "POST",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "application/json",
    },
    body: JSON.stringify(params),
  }).then((response) => {
    if (response.ok) return response.json();
    return libError(response);
  });
}

function urlSafeBase64Encode(data) {
  let base64 = btoa(data);
  return base64.replace(/\+/g, "-").replace(/\//g, "_").replace(/=+$/, "");
}

function urlSafeBase64Decode(data) {
  let base64 = data.replace(/-/g, "+").replace(/_/g, "/");
  while (base64.length % 4) {
    base64 += "=";
  }
  return atob(base64);
}

// Function to encrypt data
function encrypt(data, key) {
  const keyUtf8 = CryptoJS.enc.Utf8.parse(key);
  const iv = CryptoJS.lib.WordArray.random(16);
  const encrypted = CryptoJS.AES.encrypt(data, keyUtf8, {
    iv: iv,
    padding: CryptoJS.pad.Pkcs7,
    mode: CryptoJS.mode.CBC,
  });
  const encryptedData = iv
    .concat(encrypted.ciphertext)
    .toString(CryptoJS.enc.Base64);
  return urlSafeBase64Encode(encryptedData);
}

// Function to decrypt data
function decrypt(encryptedData, key) {
  let encryptedBase64 = urlSafeBase64Decode(encryptedData);
  let decrypted = CryptoJS.AES.decrypt(encryptedBase64, key);
  return decrypted.toString(CryptoJS.enc.Utf8);
}

function libError(err) {
  return err.json().then((error) => {
    var errorCode = error.status;
    var errorMessage = error.message ? error.message : err.name;
    Swal.fire({
      title: errorCode,
      text: errorMessage,
      icon: "error",
      showConfirmButton: false,
    });
    return Promise.reject(error);
  });
}
