export const EMAIL_REGEX = new RegExp(/^\w[a-zA-Z0-9.-]{1,126}@\w{1,124}\.\w{2,}$/);
export const PHONE_REGEX = new RegExp(/^\+[1-9][0-9]{0,2} [1-9][0-9]{8,15}$/);
export const XSS_REGEX = new RegExp(/<|>|&gt|&lt/);