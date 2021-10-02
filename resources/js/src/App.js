import React from "react";
import { Route, Switch } from "react-router-dom";
import Header from "./Layouts/Header";
import Menu from "./Layouts/Menu";
import Index from "./Components/Todo/Inex";
import Footer from "./Layouts/Footer";
import "./App.css";
import "bootstrap/dist/css/bootstrap.min.css";

class App extends React.Component {
  render() {
    return (
      <div className="container">
        <Header />
        <Menu />
        <div className="content">
          <main>
            <Switch>
              <Route
                path="/todo"
                exact
                render={(props) => {
                  return <Index {...props} />;
                }}
              />
              <Route
                path="/"
                exact
                render={(props) => {
                  return <>emty</>;
                }}
              />
            </Switch>
          </main>
          <aside>
            <ul>
              <li>home</li>
              <li>about up</li>
            </ul>
          </aside>
        </div>
        <Footer />
      </div>
    );
  }
}

export default App;
