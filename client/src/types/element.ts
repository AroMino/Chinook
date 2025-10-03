export type Gender = {
  id_gender: number;
  gender: string;
};

export type Profession = {
  profession: string;
  nb: number;
};

export type Language = {
  id_language: number;
  language: string;
};

export type Country = {
  id_country: number;
  country: string;
};

export type MovieReference = {
  id_movie: number;
};

export type Person = {
  id_person: number;
  name: string;
  gender: string;
  professions: Profession[];
  birth_year: number;
  death_year: number | null;
  height: number | null;
  image: string | null;
  score: number;
  rate_act: number;
  rate_dir: number;
  acting_movie: MovieReference[] | null;
  directing_movie: MovieReference[] | null;
};

export type Movie = {
  id_movie: number;
  title: string;
  year: number | null;
  date_published: string;
  gender: Gender[] | null;
  duration: number;
  form_duration: string;
  genders: Gender[];
  countries: Country[] | null;
  languages: Language[] | null;
  directors: Person[] | null;
  actors: Person[] | null;
  image: string | null;
  description: string | null;

  budget: number | null;
  income: number | null;

  nb_votes: number | null;
  rate: number;
  originality_score: number | null;
  popularity_score: number | null;
  actor_score: number | null;
  director_score: number | null;
  roi: number | null;
};

export type TypePerson = {
  personality: string;
};
