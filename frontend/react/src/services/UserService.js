import http from "../http-common";

const getAll = () => {
  return http.get("/all");
};

const get = id => {
  return http.get(`/detail/${id}`);
};

const create = data => {
  return http.post("/add", data);
};

const update = (id, data) => {
  return http.put(`/edit/${id}`, data);
};

const remove = id => {
  return http.delete(`/delete/${id}`);
};

const removeAll = () => {
  return http.delete(`/tutorials`);
};

const findByTitle = title => {
  return http.get(`/tutorials?title=${title}`);
};

export default {
  getAll,
  get,
  create,
  update,
  remove,
  removeAll,
  findByTitle
};
