import React, { useState } from 'react';
import api from '../services/api';

const AddStudent: React.FC = () => {
  const [matricule, setMatricule] = useState('');
  const [name, setName] = useState('');
  const [surname, setSurname] = useState('');
  const [groupId, setGroupId] = useState('');

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const response = await api.post('/students/', {
        matricule,
        name,
        surname,
        group_id: groupId,
      });
      if (response.status === 201) {
        alert('Étudiant ajouté avec succès !');
      }
    } catch (error) {
      console.error('Erreur lors de l\'ajout de l\'étudiant:', error);
      alert('Erreur lors de l\'ajout de l\'étudiant.');
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <input
        type="text"
        value={matricule}
        onChange={(e) => setMatricule(e.target.value)}
        placeholder="Matricule"
      />
      <input
        type="text"
        value={name}
        onChange={(e) => setName(e.target.value)}
        placeholder="Nom"
      />
      <input
        type="text"
        value={surname}
        onChange={(e) => setSurname(e.target.value)}
        placeholder="Prénom"
      />
      <input
        type="text"
        value={groupId}
        onChange={(e) => setGroupId(e.target.value)}
        placeholder="ID du Groupe"
      />
      <button type="submit">Ajouter un étudiant</button>
    </form>
  );
};

export default AddStudent;
