import { Component } from "react";
import axios from "axios";
import { connect } from "react-redux";
import DatePicker, { registerLocale } from "react-datepicker";
import { addTask, removeTask, doneTask } from "../../Redux/Store";
import "react-datepicker/dist/react-datepicker.css";
import "./Index.css";
import fa from "date-fns/locale/fa-IR";
registerLocale("fa-IR", fa);

class Index extends Component {
  state = {
    remote_tasks: null,
    title: null,
    description: null,
    dead_line: new Date(),
  };

  get_tasks = async () => {
    try {
      const { data, status } = await axios.get("http://localhost:3001/tasks");
      if (status !== 200) {
        throw Error("something went wrong");
      }

      //save remote data
      data.map((item) => {
        this.props.add_new_task({ ...item });
      });
    } catch (error) {
      alert(error.message);
    }
  };

  setTitle = (event) => {
    this.setState((props, state) => {
      return {
        ...state,
        title: event.target.value,
      };
    });
  };

  setDescription = (event) => {
    this.setState((props, state) => {
      return {
        ...state,
        description: event.target.value,
      };
    });
  };

  setDateTime = (event) => {
    this.setState((props, state) => {
      return {
        ...state,
        dead_line: event.target.value,
      };
    });
  };

  addTask = () => {
    const { title, description, dead_line } = { ...this.state };
    this.props.add_new_task({
      id: Math.round(Math.random() * 9999),
      title,
      description,
      dead_line,
    });
  };

  todo_list = () => {};

  render() {
    return (
      <>
        <section>
          <div className="form-group">
            <label htmlFor="titel">title</label>
            <input
              type="text"
              className="form-control"
              id="title"
              placeholder="Enter title"
              onChange={(e) => this.setTitle(e)}
            />
          </div>

          <DatePicker
            calendarClassName="bg-info m-5"
            selected={this.state.dead_line}
            onChange={(date) =>
              this.setState({
                ...this.state,
                dead_line: date,
              })
            }
            locale="fa-IR"
          />

          <div className="form-group">
            <label htmlFor="description">description</label>
            <textarea
              className="form-control"
              id="description"
              rows="3"
              onChange={(e) => this.setDescription(e)}
            ></textarea>
          </div>
          <button className="btn btn-success" onClick={this.addTask}>
            add task
          </button>
          <button className="btn btn-info" onClick={this.get_tasks}>
            load tasks
          </button>
        </section>
        <article>
          <ol>
            {this.props.todo_tasks_list.map((item) => {
              return (
                <li key={item.id}>
                  <span>title: </span>
                  <span>{item.title}</span>
                  <br />
                  <span>description: </span>
                  <span>{item.description}</span>
                  <br />
                  <span>dead line: </span>
                  <span>{item.dead_line.toLocaleDateString("fa")}</span>
                </li>
              );
            })}
          </ol>
        </article>
      </>
    );
  }
}

const injectStateToProps = (state) => {
  return {
    todo_tasks_list: state.todo,
    done_tasks_list: state.done,
  };
};

const injectDispatchToProps = (dispatch) => {
  return {
    add_new_task: (task) => {
      dispatch(addTask(task));
    },
    remove_task: (task_id) => {
      dispatch(removeTask(task_id));
    },
    done_task: (task_id) => {
      dispatch(doneTask(task_id));
    },
  };
};

export default connect(injectStateToProps, injectDispatchToProps)(Index);
