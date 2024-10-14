import { Link, useParams } from "react-router-dom";
import React, { useState, useEffect } from 'react';
import api from '../services/api';

interface Group {
    id: number;
    name: string;
}

const GroupList: React.FC = () => {
    const {courseName, courseId} = useParams()
    const [groups, setGroups] = useState<Group[]>([]);

    useEffect(() => {
        const fetchCourses = async () => {
            try {
                const response = await api.get(`/courses/${courseName}`);
                setGroups(response.data);
              } catch (error) {
                console.error('Erreur lors du chargement des groupes:', error);
              }
        };
        fetchCourses();
    }, [courseName]);
    return (
        <div>
      <h1 className='fs-1'>Liste des groupes</h1>
        {groups.map((group) => (
            <Link key={group.id} to={`/students/${group.name}/${courseId}`}>
            <div className="card text-bg-dark mb-3 w-25 mx-auto text-center d-flex">
                <div className='card-body'>
                    {group.name}
                </div>
            </div>
          </Link>
        ))}
    </div>
    );
};

export default GroupList;