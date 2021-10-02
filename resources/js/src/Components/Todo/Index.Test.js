import { render, screen } from "@testing-library/react";
import Tasks from "./Todo";

test("load tasks", () => {
  // render(<Tasks />);
  let state;
  state = reducers(
    {
      todo: [
        {
          id: 1,
          title: "title test 1",
          description:
            "lorem ipsom test description for descriptin 1 and it is just sample text",
          avatar: "https://reqres.in/img/faces/7-image.jpg",
          done: 0,
          dead_line: "2021-01-05 11:30:00",
        },
        {
          id: 2,
          title: "title test 1",
          description:
            "lorem ipsom test description for descriptin 1 and it is just sample text",
          avatar: "https://reqres.in/img/faces/8-image.jpg",
          done: 0,
          dead_line: "2021-01-05 11:30:00",
        },
        {
          id: 3,
          title: "title test 1",
          description:
            "lorem ipsom test description for descriptin 1 and it is just sample text",
          avatar: "https://reqres.in/img/faces/9-image.jpg",
          done: 0,
          dead_line: "2021-01-05 11:30:00",
        },
        {
          id: 4,
          title: "title test 1",
          description:
            "lorem ipsom test description for descriptin 1 and it is just sample text",
          avatar: "https://reqres.in/img/faces/10-image.jpg",
          done: 0,
          dead_line: "2021-01-05 11:30:00",
        },
        {
          id: 5,
          title: "title test 1",
          description:
            "lorem ipsom test description for descriptin 1 and it is just sample text",
          avatar: "https://reqres.in/img/faces/11-image.jpg",
          done: 0,
          dead_line: "2021-01-05 11:30:00",
        },
      ],
      done: [],
    },
    {
      type: "addTask",
      task: {
        id: 6,
        title: "title test 1",
        description:
          "lorem ipsom test description for descriptin 1 and it is just sample text",
        avatar: "https://reqres.in/img/faces/12-image.jpg",
        done: 0,
        dead_line: "2021-01-05 11:30:00",
      },
    }
  );
  expect(state).toEqual({
    todo: [
      {
        id: 1,
        title: "title test 1",
        description:
          "lorem ipsom test description for descriptin 1 and it is just sample text",
        avatar: "https://reqres.in/img/faces/7-image.jpg",
        done: 0,
        dead_line: "2021-01-05 11:30:00",
      },
      {
        id: 2,
        title: "title test 1",
        description:
          "lorem ipsom test description for descriptin 1 and it is just sample text",
        avatar: "https://reqres.in/img/faces/8-image.jpg",
        done: 0,
        dead_line: "2021-01-05 11:30:00",
      },
      {
        id: 3,
        title: "title test 1",
        description:
          "lorem ipsom test description for descriptin 1 and it is just sample text",
        avatar: "https://reqres.in/img/faces/9-image.jpg",
        done: 0,
        dead_line: "2021-01-05 11:30:00",
      },
      {
        id: 4,
        title: "title test 1",
        description:
          "lorem ipsom test description for descriptin 1 and it is just sample text",
        avatar: "https://reqres.in/img/faces/10-image.jpg",
        done: 0,
        dead_line: "2021-01-05 11:30:00",
      },
      {
        id: 5,
        title: "title test 1",
        description:
          "lorem ipsom test description for descriptin 1 and it is just sample text",
        avatar: "https://reqres.in/img/faces/11-image.jpg",
        done: 0,
        dead_line: "2021-01-05 11:30:00",
      },
      {
        id: 6,
        title: "title test 1",
        description:
          "lorem ipsom test description for descriptin 1 and it is just sample text",
        avatar: "https://reqres.in/img/faces/12-image.jpg",
        done: 0,
        dead_line: "2021-01-05 11:30:00",
      },
    ],
    done: [],
  });
});
