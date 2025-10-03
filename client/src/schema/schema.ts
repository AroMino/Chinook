import z from "zod"

export const YearSchema = z.object({
    yearStart: z.string(),
    yearEnd : z.string()
})
/*
export const GenreSchema = z.object({
  genre_id: z.number(),
  genre: z.string(),
});

export const CountrySchema = z.object({
  country_id: z.number(),
  country: z.string(),
});

export const LanguageSchema = z.object({
  language_id: z.number(),
  language: z.string(),
});

export const PersonSchema = z.object({
  person_id: z.number(),
  name: z.string(),
});

export const MovieSchema = z.object({
  movie_id: z.number(),
  title: z.string(),
  year: z.number().nullable(),              
  date_published: z.string(),
  genre: z.array(GenreSchema),                    
  duration: z.number(),
  country: z.array(CountrySchema),                
  language: z.array(LanguageSchema),               
  director: z.array(PersonSchema),               
  actor: z.array(PersonSchema),                    
  rate: z.number(),
  image: z.string().nullable(),
});
*/

export const MovieSchema = z.object({
  title: z.string(),
  
});

export const SearchSchema = z.object({
  search: z.string(),
  
});

export type YearType = z.infer<typeof YearSchema>
export type MovieType = z.infer<typeof MovieSchema>
export type SearchType = z.infer<typeof SearchSchema>