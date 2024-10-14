import React, { useState, useEffect } from 'react';
import api from '../services/api';
import { Link } from 'react-router-dom';

interface Course {
    id: number;
    label: string;
    group_id: number;
    group_name: string;
}

const CourseList: React.FC = () => {
    const [courses, setCourses] = useState<Course[]>([]);
  
    useEffect(() => {
      const fetchCourses = async () => {
        try {
          const response = await api.get('/courses');
          setCourses(response.data);
        } catch (error) {
          console.error('Erreur lors du chargement des cours:', error);
        }
      };
      fetchCourses();
    }, []);
  
    const filteredCourses = courses.filter((course, index, self) =>
      index === self.findIndex((c) => c.label === course.label)
    );

    return (
      <div>
        <h1 className='fs-1'>Liste des cours</h1>
          {filteredCourses.map((course) => (
            <Link key={course.id} to={`/${course.label}/${course.id}/group`}>
              <div className="card text-bg-dark mb-3 w-25 mx-auto text-center d-flex">
                <div className='card-body'>
                {course.label}
                </div>
              </div>
            </Link>
          ))}
      </div>
    );
};

export default CourseList;