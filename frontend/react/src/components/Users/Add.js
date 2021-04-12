import React, { useState } from "react";
import UserData from "../../services/UserService";
import {
  Button,
  Card,
  CardHeader,
  CardBody,
  CardFooter,
  CardText,
  FormGroup,
  Form,
  Input,
  Row,
  Col,
} from "reactstrap";
import { Redirect } from "react-router-dom"

const AddUser = (props) => {
  const initialUserState = {
    id: null,
    first_name: "",
    last_name: "",
    username: "",
    password: "",
    email: "",
    published: false,
    props
  };
  const [user, setUser] = useState(initialUserState);
  const [submitted, setSubmitted] = useState(false);

  const handleInputChange = event => {
    const { name, value } = event.target;
    setUser({ ...user, [name]: value });
  };

  const saveUser = () => {
    var data = {
      first_name: user.first_name,
      last_name: user.last_name,
      username: user.username,
      password: user.password,
      email: user.email
    };

    UserData.create(data)
      .then(response => {
        setUser({
          first_name: response.data.first_name,
          last_name: response.data.last_name,
          username: response.data.username,
          password: response.data.password,
          email: response.data.email
        });
        setSubmitted(true);
        console.log(response.data);
      })
      .catch(e => {
        console.log(e);
      });
  };

  return (

    <div className="content">
      {submitted ? <Redirect to="/admin/users" /> : (
        <div>
          <Row>
            <Col md="8">
              <Card>
                <CardHeader>
                  <h5 className="title">Add New User</h5>
                </CardHeader>
                <CardBody>
                  <div>
                    <Row>
                      <Col className="pr-md-6" md="6">
                        <FormGroup>
                          <label htmlFor="title">First Name</label>
                          <Input
                            type="text"
                            className="form-control"
                            id="first_name"
                            required
                            value={user.first_name}
                            onChange={handleInputChange}
                            name="first_name"
                          />
                        </FormGroup>
                      </Col>
                      <Col className="pr-md-6" md="6">

                        <FormGroup>
                          <label htmlFor="last_name">Last Name</label>
                          <Input
                            type="text"
                            className="form-control"
                            id="last_name"
                            required
                            value={user.last_name}
                            onChange={handleInputChange}
                            name="last_name"
                          />
                        </FormGroup>
                      </Col>
                    </Row>

                    <Row>
                      <Col className="pr-ml-4" md="4">
                        <FormGroup>
                          <label htmlFor="username">Username</label>
                          <Input
                            type="text"
                            className="form-control"
                            id="username"
                            required
                            value={user.username}
                            onChange={handleInputChange}
                            name="username"
                          />
                        </FormGroup>
                      </Col>
                      <Col className="pr-ml-4" md="4">
                        <FormGroup>
                          <label>Email</label>
                          <Input
                            type="email"
                            className="form-control"
                            id="email"
                            required
                            value={user.email}
                            onChange={handleInputChange}
                            name="email"
                          />
                        </FormGroup>
                      </Col>
                      <Col className="pr-ml-4" md="4">
                        <FormGroup>
                          <label>Password</label>
                          <Input
                            type="password"
                            className="form-control"
                            id="password"
                            required
                            value={user.password}
                            onChange={handleInputChange}
                            name="password"
                          />
                        </FormGroup>
                      </Col>
                    </Row>

                    <Button onClick={saveUser} className="btn btn-success">
                      Submit
                    </Button>
                  </div>


                </CardBody>
                <CardFooter>

                </CardFooter>
              </Card>
            </Col>
          </Row>
        </div>
      )}
    </div>
  );
};

export default AddUser;
