import { useParams } from "react-router-dom";
import React, { useState, useEffect } from 'react';
import api from '../services/api';

interface Student {
  matricule: number;
  name: string;
  surname: string;
  group_id: number;
  group_name: string;
}

const StudentsList: React.FC = () => {
  const {groupName, courseId} = useParams()
  const [students, setStudents] = useState<Student[]>([]);

  useEffect(() => {
    const fetchStudents = async () => {
      try {
        const response = await api.get(`/students/${groupName}`);
        setStudents(response.data);
      } catch (error) {
        console.error('Erreur lors du chargement des étudiants:', error);
      }
    };
    fetchStudents();
  }, [groupName]);

  const handlePresenceChange = async (studentId: number, isPresent: boolean) => {
    try {
      if (isPresent) {
        // Envoyer une requête POST pour insérer la présence
        await api.post('/presences', {
          student_id: studentId,
          course_id: courseId,
          date: new Date().toISOString().split('T')[0] // Date du jour au format 'YYYY-MM-DD'
        });
      } else {
        // Récupérer l'ID de la présence et envoyer une requête DELETE
        const response = await api.get(`/presences?student_id=${studentId}&course_id=${courseId}`);
        if (response.data.length > 0) {
          const presenceId = response.data[0].id;
          await api.delete(`/presences/${presenceId}`);
        }
      }
      alert('Présence mise à jour avec succès');
    } catch (error) {
      console.error('Erreur lors de la mise à jour de la présence:', error);
    }
  };

  return (
    <div>
      <h1 className='fs-1'>Liste des étudiants</h1>
        {students.map((student) => (
          <div className="card-group">
            <div key={student.matricule} className="card text-bg-dark mb-3 w-25 mx-auto text-center d-flex">
              <div className='card-body'>
                {student.name} 
              </div>
            </div>
            <div key={student.matricule} className="card text-bg-dark mb-3 w-25 mx-auto text-center d-flex">
              <div className='card-body'>
                {student.surname} 
              </div>
            </div>
            <div key={student.matricule} className="card text-bg-dark mb-3 w-25 mx-auto text-center d-flex">
              <div className='card-body'>
                 {student.matricule}
              </div>
            </div>
            <div key={student.matricule} className="card text-bg-dark mb-3 w-25 mx-auto text-center d-flex">
              <div className='card-body'>
                <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault" onChange={(e) => handlePresenceChange(student.matricule, e.target.checked)}></input>
              </div>
            </div>
          </div>
        ))}
    </div>
  );
};

export default StudentsList;
