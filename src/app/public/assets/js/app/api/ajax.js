import {Response} from "../controllers/services/Response.js";

export async function ajax(endPoint, typeMethod, data = null, sendInJson = true) {
    const properties = {
        method: typeMethod,
        headers: {
            'Accept': 'application/json'
        }
    }
    if (data) {
        if (sendInJson) {
            properties.headers['Content-Type'] = 'application/json';
            properties.body = JSON.stringify(data)
        } else {
            properties.body = data
        }
    }
    return new Response(await fetch(endPoint, properties).then(response => response.json()));
}