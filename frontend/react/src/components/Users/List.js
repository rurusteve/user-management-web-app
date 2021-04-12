import React, { Component } from 'react'
import { Link } from 'react-router-dom'
import {
    Card, CardHeader, CardBody, CardTitle, Table, Row, Col,
    Button, Modal, ModalBody
  } from "reactstrap";
import { faEnvelope, faUser, faPhone, faCode, faPen} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import UserData from "./../../services/UserService"
import {connect} from 'react-redux'

class List extends Component {
    
    constructor(props) {
        super(props);
        this.state = {
            deleteToggle: false,
            users: [],
        };
        this.deleteConfirmationToggle = this.deleteConfirmationToggle.bind(this);
    }

    deleteConfirmationToggle(){
        this.setState({
            deleteToggle: !this.state.deleteToggle
        });
    }
      
      async componentDidMount() {
        const url = "http://localhost:8000/api/users/all";
        const response = await fetch(url);
        const data = await response.json();
        this.setState({ users: data, loading: false });
      }
    
      removeUser = (id, data) => {
        UserData.remove(id)
          .then(response => {
            console.log(response.data);
            this.setState({
                deleteToggle: !this.state.deleteToggle,
            });
            this.componentDidMount();
          })
          .catch(e => {
            console.log(e);
          });
      };

      
  render() {
    return (
        <>
          <div className="content">
            <Row>
            <Col md="12">
                <Card className="card-plain">
                    <CardHeader tag="h4">
                        <CardTitle> User List</CardTitle>
                    </CardHeader>
                    <CardBody>
                    <Table className="tablesorter" responsive>
                      <thead className="text-primary">
                        <tr>
                        <th><FontAwesomeIcon icon={faUser} /> Name</th>
                        <th><FontAwesomeIcon icon={faEnvelope} /> Email</th>
                        <th><FontAwesomeIcon icon={faPhone} /> Phone</th>
                        <th><FontAwesomeIcon icon={faCode} /> Username</th>
                        <th><FontAwesomeIcon icon={faPen} /> Option</th>
                        </tr>
                      </thead>
                      <tbody>
                  {this.state.users.length === 0 ?
                    <tr>
                      <td colSpan='5' className='text-center'>There are no users created yet.</td>
                    </tr> : this.state.users.map((user, i) => (
                        <tr key={i}>
                          <td className='name-cell'>
                            <Link to={{
                                    pathname: `/admin/user-profile`,
                                    state: {
                                    user: user.first_name,
                                    },
                                }}>{user.first_name} {user.last_name}</Link>
                          </td>
                          <td>
                          <a href={`mailto:${user.email}`}>{user.email}</a>
                          </td>
                          <td>
                            +62{user.phone_number}
                          </td>
                          <td>
                            {user.username}
                          </td>
                          <td>
                          <Button className="btn btn-sm btn-danger" onClick={this.deleteConfirmationToggle}>Delete</Button>
                          <Modal isOpen={this.state.deleteToggle} toggle={this.deleteConfirmationToggle}>
                            <div className="modal-header">
                            <h5 className="modal-title" id="exampleModalLabel">
                                Warning
                            </h5>
                            <button
                            type="button"
                            className="close"
                            data-dismiss="modal"
                            aria-hidden="true"
                            onClick={this.deleteConfirmationToggle}>
                                <i className="tim-icons icon-simple-remove" />
                            </button>
                            </div>
                            <ModalBody>
                                <p>Are you sure you're going to remove {user.first_name} from user?</p>
                                <Button color="primary" onClick={this.toggleModalDemo}>
                                    Cancel
                                </Button>
                                <Button onClick={(e) => this.removeUser(user.id, e)} color="default">
                                    Yes
                                </Button>
                            </ModalBody>
                            </Modal>
                          {/* <Link to='/edit' className='btn btn-primary btn-sm '>Edit</Link> */}
                          </td>
                        </tr>
                      ))}
                </tbody>
              
                    </Table>
                  </CardBody>
                
                </Card>
              <Table
                className='table table-hover'
                bordered
                condensed
                hover
                style={{
                  marginBottom: '0',
                  marginTop: '15px'
                }}>
                <thead>
                  <tr>
     
                  </tr>
                </thead>
                </Table>
              <Link to='/admin/add/user' className='btn btn-success btn-md mt-3 mb-3'><FontAwesomeIcon icon={faUser} /> Add User</Link>
          </Col>
            </Row>
          </div>
        </>
      );
  }
}

export default List

//   function mapUser(state) {
//     return {
//       value: state.user
//     };
//   }
  
// export default connect(List)(mapUser)
