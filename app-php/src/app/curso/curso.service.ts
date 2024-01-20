import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { catchError, map } from 'rxjs/operators';
import { Curso } from './curso';
import { Observable, throwError } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CursoService {

  // URL base para as chamadas de API
  url: string = "http://localhost/api/php/";

  // Vetor para armazenar os dados dos cursos
  vetor_cursos: Curso[] = [];
  
  // Construtor, injetando o serviço HttpClient
  constructor(private http: HttpClient) { }

  // Método para obter todos os cursos
  obterCursos(): Observable<Curso[]> {
    return this.http.get<{ cursos: Curso[] }>(this.url + 'listar.php').pipe(
      map((res) => {
        // Mapeia a resposta, armazena os cursos localmente e retorna
        this.vetor_cursos = res['cursos'];
        return this.vetor_cursos;
      })
    );
  }

  // Método para cadastrar um novo curso
  cadastrarCurso(c: Curso): Observable<Curso[]> {
    return this.http.post(this.url + "cadastrar.php", { curso: c })
      .pipe(map((res) => {
        // Mapeia a resposta, adiciona o novo curso localmente e retorna
        this.vetor_cursos.push(res as Curso);
        return this.vetor_cursos;
      }));
  }

  // Método para remover um curso
  removerCurso(c: Curso): Observable<Curso[]> {
    const params = new HttpParams().set("idCurso", c.idCurso!.toString());
    return this.http.delete(`${this.url}excluir.php`, { params: params })
      .pipe(
        map((res: any) => {
          // Mapeia a resposta, filtra os cursos removendo o desejado e retorna
          const filtro = this.vetor_cursos.filter((curso) => {
            return +curso['idCurso']! !== +c.idCurso!;
          });
          return this.vetor_cursos = filtro;
        }),
        catchError(error => this.handleError(error))
      );
  }

  // Método para atualizar um curso
  atualizarCurso(c: Curso): Observable<Curso[]> {
    return this.http.put(this.url + "alterar.php", { cursos: c })
      .pipe(map((res: any) => {
        // Mapeia a resposta, encontra o curso a ser atualizado, atualiza localmente e retorna
        const cursoAlterado = this.vetor_cursos.find((item) => {
          return +item['idCurso']! === +c.idCurso!;
        });
        if (cursoAlterado) {
          cursoAlterado['nomeCurso'] = c['nomeCurso'];
          cursoAlterado['valorCurso'] = c['valorCurso'];
        }
        return this.vetor_cursos;
      }));
  }

  // Método privado para tratar erros
  private handleError(error: any): Observable<never> {
    console.error('Erro na requisição:', error);
    return throwError('Erro na requisição. Verifique o console para mais detalhes.');
  }
}
