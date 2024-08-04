import { DestroyRef, inject, Inject, Injectable, InjectionToken, signal } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { finalize, Observable, take, tap } from 'rxjs';
import { environment } from '../../environments/environment';

export const RESOURCE_URL = new InjectionToken<string>('RESOURCE_URL');
@Injectable({ providedIn: 'root' })
export class CRUDService<Model> {
    protected apiUrl?: string;
    private message = signal<string>('');
    private loading = signal<boolean>(false);
    private destroy = inject(DestroyRef);

    constructor(protected httpClient: HttpClient, @Inject(RESOURCE_URL) resourceUrl: string) {
        this.apiUrl = `${environment.apiUrl}${resourceUrl}`;
    }

    getMessage() {
        return this.message;
    }

    getLoading() {
        return this.loading;
    }

    show(perPage: number = 10, page: number = 1, search: string = '', is_done?: number | null): Observable<{ pages: number, total: number, search: string, itens: Model[] }> {
        this.loading.set(true);
        let params = new HttpParams()
            .set('perPage', perPage)
            .set('page', page)
            .set('search', search);
            if (is_done == 0 || is_done  == 1) {
                params = params.set('is_done', is_done);
            }
        return this.httpClient.get<{ pages: number, total: number, search: string, itens: Model[] }>(`${this.apiUrl}/show`, { params })
            .pipe(
                take(1),
                finalize(() => this.loading.set(false))
            );
    }

    showById(id: string): Observable<Model> {
        this.loading.set(true);
        return this.httpClient.get<Model>(`${this.apiUrl}/show-by-id/${id}`)
            .pipe(
                take(1),
                finalize(() => this.loading.set(false))
            );
    }

    showWithoutPagination(fields: string[]): Observable<Model[]> {
        this.loading.set(true);
        let params = new HttpParams().set('fields', JSON.stringify(fields));
        return this.httpClient.get<Model[]>(`${this.apiUrl}/show-without-pagination`, { params })
            .pipe(
                take(1),
                finalize(() => this.loading.set(false))
            );
    }

    store(model: Model | FormData): Observable<{ message: string; id?: string }> {
        this.loading.set(true);
        return this.httpClient.post<{ message: string; id?: string }>(`${this.apiUrl}/store`, model)
            .pipe(
                take(1),
                finalize(() => this.loading.set(false)),
                tap(response => {
                    this.message.set(response.message);
                    const clearMessageTimeout = setTimeout(() => {
                        this.message.set('');
                    }, 5000);
                    this.destroy.onDestroy(() => clearTimeout(clearMessageTimeout));
                })
            );
    }


    update(model: Model | FormData, id: string): Observable<{ message: string }> {
        this.loading.set(true);
        return this.httpClient.put<{ message: string }>(`${this.apiUrl}/update/${id}`, model)
            .pipe(
                take(1),
                finalize(() => this.loading.set(false)),
                tap(response => {
                    this.message.set(response.message);
                    const clearMessageTimeout = setTimeout(() => {
                        this.message.set('');
                    }, 5000);
                    this.destroy.onDestroy(() => clearTimeout(clearMessageTimeout));
                })
            );
    }

    delete(id: string): Observable<{ message: string }> {
        this.loading.set(true);
        return this.httpClient.delete<{ message: string }>(`${this.apiUrl}/delete/${id}`)
            .pipe(
                take(1),
                finalize(() => this.loading.set(false)),
                tap(response => {
                    this.message.set(response.message);
                    const clearMessageTimeout = setTimeout(() => {
                        this.message.set('');
                    }, 5000);
                    this.destroy.onDestroy(() => clearTimeout(clearMessageTimeout));
                })
            );
    }
}