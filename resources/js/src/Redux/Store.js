// import { combineReducers } from "redux";
import { createStore } from "redux";
import todo_reducer, {
  addTask,
  removeTask,
  doneTask,
} from "./Todo/TodoReducer";

//create store
const storage = createStore(todo_reducer, window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__());

//listen to store
// storage.subscribe(() => {
//   console.log("[redux changed]", storage.getState());
// });

//dispatch store
// createStore.dispatch(addTask);

export { addTask, removeTask, doneTask, storage };
