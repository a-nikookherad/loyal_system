//todo actions name
const Add = "addTask";
const Remove = "removeTask";
const Done = "doneTask";

//todo actions
export const addTask = (task) => ({ type: Add, task });
export const removeTask = (task_id) => ({ type: Remove, task_id });
export const doneTask = (task_id) => ({ type: Done, task_id });

//todo reducer
const init_reducer = {
  todo: [],
  done: [],
};

const todo_reducer = (state = init_reducer, action) => {
  switch (action.type) {
    case Add:
      return {
        ...state,
        todo: [...state.todo, action.task],
      };

    case Remove:
      let new_todo = state.todo.filter((item) => {
        return item.id !== action.task_id && item.done != true;
      });
      return {
        ...state,
        todo: [...new_todo],
      };

    case Done:
      const edit_todo = state.todo.map((item) => {
        if (item.id === action.task_id) {
          return { ...item, done: true };
        }
        return { ...item };
      });

      const todo = edit_todo.filter((item) => {
        return item.done == false;
      });

      const done = edit_todo.fillter((item) => {
        return item.done == true;
      });

      return {
        ...state,
        todo: [...todo],
        done: [...done],
      };
  }

  return state;
};

export default todo_reducer;
