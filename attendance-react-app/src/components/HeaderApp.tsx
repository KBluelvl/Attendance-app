import { Link } from 'react-router-dom';
import reactLogo from '../assets/react.svg'


function HeaderApp(){
    return  <header>
              <nav className="navbar navbar-expand-lg">
                <Link to='/' className='me-5'>
                  <nav className="navbar">
                    <img src={reactLogo} className="logo react" alt="React logo" />
                    <h1>Attendance App</h1>
                  </nav>
                </Link>
                <div className="collapse navbar-collapse" id="navbarNav">
                  <ul className="navbar-nav">
                    <li className="link">
                      <Link to='/students' className='me-5'>Student</Link>
                    </li>
                  </ul>
                </div>
              </nav>
            </header>
}

export default HeaderApp;