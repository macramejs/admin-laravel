
type TRequestInit = RequestInit | { body: {[k:string]: any}};

function request(url: RequestInfo, options: TRequestInit = {}) {
    const token = (<HTMLInputElement>document.querySelector('input[name="_token"]')).value;
    const headers = {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": token
    };

    if('body' in options) {
        options.body = JSON.stringify(options.body)
    }

    return fetch(url, { headers, ...<RequestInit>options  });
}

const get = (url: RequestInfo, options: TRequestInit = {}) => request(url, { ...options, method: 'GET'});
const put = (url: RequestInfo, options: TRequestInit = {}) => request(url, { ...options, method: 'PUT'});
const post = (url: RequestInfo, options: TRequestInit = {}) => request(url, { ...options, method: 'POST'});
const del = (url: RequestInfo, options: RequestInit = {}) => request(url, { ...options, method: 'DELETE'});

export { request, post, get, put, del };