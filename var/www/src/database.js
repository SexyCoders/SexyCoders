function getServices(token)
  {
    var send={};
    send.token=token;
    send=btoa(JSON.stringify(send));
  $.ajax({
    type: 'POST',
    data: send, 
    url: store.etc.rest+"/etc/services",
    success:
    (response) =>
        {
          store.etc.services=JSON.parse(atob(response)).services;
        },
    error:
    (response) =>
          {
                    onAuthError();
          },
      async:false
      });
  }

function getDatabases(token)
  {
    var send={};
    send.token=token;
    send=btoa(JSON.stringify(send));
  $.ajax({
    type: 'POST',
    data: send, 
    url: store.etc.rest+"/etc/databases",
    success:
    (response) =>
        {
          store.etc.databases=JSON.parse(atob(response)).databases;
        },
    error:
    (response) =>
          {
                    onAuthError();
          },
      async:false
      });
  }

function getUserInfo(token){
  resolveApiEndpoint('userinfo_endpoint');
  $.ajax({
    type: 'GET',
    url: store.tmp.lastResolvedEndpoint,
    headers: {
      'Authorization': 'Bearer '+token
    },
    success:
    (response) =>
        {
          store.etc.user=response;
        },
    error:
    (response) =>
          {
                    onAuthError();
          },
      async:false
      });

};

