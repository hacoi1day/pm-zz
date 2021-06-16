import http from 'k6/http';
import { sleep } from 'k6';

export const options = {
    stages: [
        { duration: '1m', target: 100 },
        { duration: '30s', target: 200 },
        { duration: '1m', target: 200 },
        { duration: '30s', target: 400 },
        { duration: '1m', target: 400 },
        { duration: '4m', target: 0 },
    ],
}

export default function() {
    let url = 'http://api.pm.local/';
    let res = http.get(url);
    
    sleep(1);
}