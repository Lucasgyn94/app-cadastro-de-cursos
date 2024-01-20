import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { Curso } from './curso';
import { CursoService } from './curso.service';

@Component({
  selector: 'app-curso',
  templateUrl: './curso.component.html',
  styleUrls: ['./curso.component.css']
})
export class CursoComponent implements OnInit {

  // Url base da nossa api
  url: string = "http://localhost/api/php/";

  // vetor para armazenar as informações
  vetor_curso: Curso[] = [];

  // objeto da classe curso
  curso = new Curso();

  // construtor
  // O http sera o responsavel por enviar os dados ao nosso bd ou capturar essas informações.
  constructor(private curso_servico: CursoService) { }
  
  // inicializador
  ngOnInit(): void {
    // Ao iniciar, o sistema deverá listar os cursos
    this.selecao();
  }

  // cadastro
  cadastrar() { 
    // Verifica se as propriedades necessárias estão definidas
    if (this.curso.nomeCurso && this.curso.valorCurso !== undefined) {
      // subscribe nos dá acesso aos dados
      this.curso_servico.cadastrarCurso(this.curso).subscribe(
        (res: Curso[]) => {
          // Adicionando dados ao vetor
          this.vetor_curso = res;

          // limpar os atributos
          this.curso.nomeCurso = "";
          this.curso.valorCurso = 0;

          // atualizar a listagem de cursos
          this.selecao();
        },
        (error) => {
          // Lidar com erros, se necessário
          console.error("Erro ao cadastrar curso:", error);
        }
      );
    } else {
      console.error("Dados de curso inválidos");
    }
  }

  // seleção
  selecao() {
    this.curso_servico.obterCursos().subscribe(
      (res) => {
        this.vetor_curso = res;
      },
      (error) => {
        // Lidar com erros, se necessário
        console.error("Erro ao obter cursos:", error);
      }
    );
  }

  // alterar
  alterar() {
    this.curso_servico.atualizarCurso(this.curso).subscribe(
      (res) => {
        // atualizar vetor
        this.vetor_curso = res;

        // limpar os valores do objeto
        this.curso.nomeCurso = "";
        this.curso.valorCurso = 0;

        // atualiza a listagem
        this.selecao();
      }
    )
  }

  // remover
  remover() {
      this.curso_servico.removerCurso(this.curso).subscribe(
        (res: Curso[]) => {
          this.vetor_curso = res;

          this.curso.nomeCurso = "";
          this.curso.valorCurso = 0;
        }
      )
  }

  // selecionar curso específico
  selecionarCurso(c: Curso) {
    this.curso.idCurso = c.idCurso;
    this.curso.nomeCurso = c.nomeCurso;
    this.curso.valorCurso = c.valorCurso;
  }
}
