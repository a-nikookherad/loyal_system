import { Link } from "react-router-dom";
import "./Index.css";

const Menu = () => {
  return (
    <nav>
      <Link to="/">home</Link>
      <Link to="/todo">content</Link>
    </nav>
  );
};

export default Menu;
