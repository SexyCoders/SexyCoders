
export function resolveApiEndpoint(endpoint){
  $.ajax({
    type: 'GET',
    url: "http://localhost:8989/realms/testing/.well-known/openid-configuration",
    success:
    (response) =>
        {
          store.tmp.lastResolvedEndpoint=response[endpoint];
        },
    error:
    (response) =>
          {
            onAuthError();
            alert("Api could not be resolved!\nPlease reach out to the system admin!");
          },
      async:false
      });
};

export function resolveCompany(token)
  {
    var send={};
    send.token=token;
    send=btoa(JSON.stringify(send));
  $.ajax({
    type: 'POST',
    data: send, 
    url: store.etc.rest+"/resolve/company",
    success:
    (response) =>
        {
          store.etc.company=JSON.parse(atob(response)).company;
        },
    error:
    (response) =>
          {
                    onAuthError();
          },
      async:false
      });
  }
export function resolveGroup(token)
  {
    var send={};
    send.token=token;
    send=btoa(JSON.stringify(send));
  $.ajax({
    type: 'POST',
    data: send, 
    url: store.etc.rest+"/resolve/group",
    success:
    (response) =>
        {
          store.etc.group=JSON.parse(atob(response)).groups;
        },
    error:
    (response) =>
          {
                    onAuthError();
          },
      async:false
      });
  }
