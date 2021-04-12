import React from "react";

// reactstrap components
import { Container, Nav, NavItem, NavLink } from "reactstrap";

function Footer() {
  return (
    <footer className="footer">
      <Container fluid>
        <Nav>
          <NavItem>
            <NavLink href="https://github.com/rurusteve/user-management-web-app">
              Github
            </NavLink>
          </NavItem>
          <NavItem>
            <NavLink href="https://github.com/rurusteve/user-management-web-app">
              Curriculum Vitae
            </NavLink>
          </NavItem>
          </Nav>
        </Container>
    </footer>
  );
}

export default Footer;
