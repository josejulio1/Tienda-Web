export class Response {
    constructor(json) {
        this.status = json['status'];
        this.message = json['message'] ?? null;
        this.data = json['data'] ?? null;
    }
}