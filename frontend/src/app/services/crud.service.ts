import { HttpClient } from "@angular/common/http";
import { Inject, Injectable, InjectionToken } from "@angular/core";
import { Observable, take } from "rxjs";
import { environment } from "src/environments/environment";

export const RESOURCE_URL = new InjectionToken<string>('RESOURCE_URL');

@Injectable({ providedIn: 'root' })
export class CrudService<Model> {
    private apiUrl: string;

    constructor(protected httpClient: HttpClient, @Inject(RESOURCE_URL) resourceUrl: string) {
        this.apiUrl = `${environment.apiUrl}/${resourceUrl}`;
    }

    show(): Observable<Model[]> {
        return this.httpClient.get<Model[]>(`${this.apiUrl}/show`)
            .pipe(take(1));;
    }

    showById(id: string): Observable<Model> {
        return this.httpClient.get<Model>(`${this.apiUrl}/show-by-id/${id}`)
            .pipe(take(1));;
    }

    store(model: Model) {
        return this.httpClient.post<Model>(`${this.apiUrl}/store`, model)
            .pipe(take(1));;
    }

    update(model: Model, id: string) {
        return this.httpClient.put<Model>(`${this.apiUrl}/update/${id}`, model)
            .pipe(take(1));;
    }

    delete(id: string): Observable<{ message: string }> {
        return this.httpClient.delete<{ message: string }>(`${this.apiUrl}/delete/${id}`)
            .pipe(take(1));
    }
}
