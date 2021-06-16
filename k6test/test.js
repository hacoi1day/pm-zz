import http from 'k6/http';
import { sleep } from 'k6';

export const options = {
    stages: [
        { duration: '1m', target: 10000 },
    ],
}

export default function() {
    let url = 'http://api.pm.local/api/v1/login';
    let payload = JSON.stringify({
        email: 'admin@gmail.com',
        password: '123456'
    });

    let params = {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    }
    http.post(url, payload, params);
    sleep(1);
}