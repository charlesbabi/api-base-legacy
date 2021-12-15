const policies = [
  // Referer will never be set.
  "no-referrer",

  // Referer will not be set when navigating from HTTPS to HTTP.
  "no-referrer-when-downgrade",

  // Full Referer for same-origin requests, and no Referer for cross-origin requests.
  "same-origin",

  // Referer will be set to just the origin, omitting the URL's path and search.
  "origin",

  // Referer will be set to just the origin except when navigating from HTTPS to HTTP,
  // in which case no Referer is sent.
  "strict-origin",

  // Full Referer for same-origin requests, and bare origin for cross-origin requests.
  "origin-when-cross-origin",

  // Full Referer for same-origin requests, and bare origin for cross-origin requests
  // except when navigating from HTTPS to HTTP, in which case no Referer is sent.
  "strict-origin-when-cross-origin",

  // Full Referer for all requests, whether same- or cross-origin.
  "unsafe-url",
];

const apiData = {
  urlBase: "http://localhost:8080/apibase",
  loginPage: "/apibase/test/login.php",
  homePage: "/apibase/test/home.php",
};

let policySelected = policies[0];

const postApi = async (url, data, token = "") => {
  if (token === "") {
    token = window.localStorage.getItem("token") ?? "";
  }
  const response = await fetch(apiData.urlBase + url, {
    method: "POST",
    mode: "cors",
    cache: "no-cache",
    headers: {
      "Content-Type": "application/json",
      Authorization: "Bearer " + token.toString(),
      "Access-Control-Allow-Origin": "*",
    },
    referrerPolicy: policySelected,
    body: JSON.stringify(data),
  });
  return response.json();
};

const putApi = async (url, data, token = "") => {
  if (token === "") {
    token = window.localStorage.getItem("token") ?? "";
  }
  const response = await fetch(apiData.urlBase + url, {
    method: "PUT",
    mode: "cors",
    cache: "no-cache",
    headers: {
      "Content-Type": "application/json",
      Authorization: "Bearer " + token.toString(),
      "Access-Control-Allow-Origin": "*",
    },
    referrerPolicy: policySelected,
    body: JSON.stringify(data),
  });

  return response.json();
};

const deleteApi = async (url, data, token = "") => {
  if (token === "") {
    token = window.localStorage.getItem("token") ?? "";
  }
  const response = await fetch(apiData.urlBase + url, {
    method: "DELETE",
    mode: "cors",
    cache: "no-cache",
    headers: {
      "Content-Type": "application/json",
      Authorization: "Bearer " + token.toString(),
      "Access-Control-Allow-Origin": "*",
    },
    referrerPolicy: policySelected,
    body: JSON.stringify(data),
  });
  return response.json();
};

const getApi = async (url, token = "") => {
  if (token === "") {
    token = window.localStorage.getItem("token") ?? "";
  }
  const response = await fetch(apiData.urlBase + url, {
    method: "GET",
    mode: "cors",
    cache: "no-cache",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token.toString()}`,
      "Access-Control-Allow-Origin": "*",
    },
    referrerPolicy: policySelected,
  });
  return response.json();
};

const isLogged = () => {
  return (
    localStorage.getItem("token") && localStorage.getItem("logged") === "true"
  );
};

const verifyLogin = () => {
  if (isLogged()) {
    if (!window.location.href.includes(apiData.homePage)) {
      redir(apiData.homePage);
    }
  } else {
    if (!window.location.href.includes(apiData.loginPage)) {
      redir(apiData.loginPage);
    }
  }
};

const redir = (url) => {
  window.location.href = url;
};

const login = (user, pass) => {
  postApi("/v1/usuarios/login", {
    usuario: user,
    clave: pass,
  }).then((response) => {
    if (response.data) {
      localStorage.setItem("token", response.data);
      localStorage.setItem("logged", true);
      redir(apiData.homePage);
    }
  });
};

const logout = () => {
  localStorage.removeItem("token");
  localStorage.removeItem("logged");
  verifyLogin();
};
