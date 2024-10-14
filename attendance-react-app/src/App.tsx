import './App.css'
import { Fragment } from 'react';
import HeaderApp from './components/HeaderApp';
import CourseList from './components/CourseList';
import GroupList from './components/GroupList';
import StudentList from './components/StudentList';
import AddStudent from './components/AddStudent';
import { createBrowserRouter, RouterProvider } from 'react-router-dom';

const router = createBrowserRouter([
  {
    path: '/',
    element: (
      <Fragment>
        <HeaderApp />
        <CourseList />
      </Fragment>
    )
  },
  {
    path: '/:courseName/:courseId/group',
    element: (
      <Fragment>
        <HeaderApp />
        <GroupList /> 
      </Fragment>
    )
  },
  {
    path: '/students/:groupName/:courseId',
    element: (
      <Fragment>
        <HeaderApp />
        <StudentList />
      </Fragment>
    )
  },
  {
    path: '/students',
    element: (
      <Fragment>
        <HeaderApp />
        <AddStudent />
      </Fragment>
    )
  }
])

function App() {
  return <RouterProvider router={router} />
}

export default App
