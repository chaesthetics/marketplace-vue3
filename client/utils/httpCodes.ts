const httpCodes: Map<number, string> = new Map([
  [429, "Too many requests"],
  [401, "Unauthorized"],
  [422, "Unprocessable Content"],
  [500, "Internal Server Error"],
]);

export default httpCodes;
