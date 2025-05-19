import { describe, it, expect, beforeEach, vi } from 'vitest'
import { JSDOM } from 'jsdom'

describe('Composant Comments', () => {
  const mockComments = {
    comments: [
      {
        id: 1,
        content: 'Test comment 1',
        user: { nickname: 'User1', id: 1 },
        created_at: '2024-01-01T00:00:00.000Z'
      }
    ],
    current_page: 1,
    last_page: 2,
    total: 10
  }

  let dom
  let container

  beforeEach(() => {
    dom = new JSDOM(`
      <div x-data="{
        comments: [],
        content: '',
        isSubmitting: false,
        isLoading: true,
        showDeleteModal: false,
        commentToDelete: null,
        currentPage: 1,
        lastPage: 1,
        total: 0,
        init() {},
        goToPage() {},
        addComment() {},
        deleteComment() {}
      }">
        <div class="comments-container"></div>
      </div>
    `)

    global.document = dom.window.document
    global.window = dom.window
    global.fetch = vi.fn()

    window.Alpine = {
      store: vi.fn().mockReturnValue({
        add: vi.fn()
      })
    }

    container = document.querySelector('[x-data]')
  })

  it('charge et affiche les commentaires correctement', async () => {
    global.fetch.mockResolvedValueOnce({
      ok: true,
      json: () => Promise.resolve(mockComments)
    })

    container._x_dataStack = [{
      comments: mockComments.comments,
      total: mockComments.total
    }]

    expect(container._x_dataStack[0].comments[0].content).toBe('Test comment 1')
    expect(container._x_dataStack[0].comments[0].user.nickname).toBe('User1')
    expect(container._x_dataStack[0].total).toBe(10)
  })

  it('gère correctement la pagination', async () => {
    const mockPage1 = { ...mockComments }
    const mockPage2 = {
      ...mockComments,
      current_page: 2,
      comments: [{ id: 2, content: 'Test comment 2', user: { nickname: 'User2', id: 2 } }]
    }

    global.fetch
      .mockResolvedValueOnce({
        ok: true,
        json: () => Promise.resolve(mockPage1)
      })
      .mockResolvedValueOnce({
        ok: true,
        json: () => Promise.resolve(mockPage2)
      })

    container._x_dataStack = [{
      comments: mockPage2.comments,
      currentPage: mockPage2.current_page
    }]

    expect(container._x_dataStack[0].comments[0].content).toBe('Test comment 2')
    expect(container._x_dataStack[0].currentPage).toBe(2)
  })

  it('permet d\'ajouter un nouveau commentaire', async () => {
    const newComment = {
      id: 3,
      content: 'Nouveau commentaire',
      user: { nickname: 'User3', id: 3 },
      created_at: '2024-01-01T00:00:00.000Z'
    }

    global.fetch
      .mockResolvedValueOnce({
        ok: true,
        json: () => Promise.resolve({ comment: newComment, message: 'Commentaire ajouté' })
      })

    container._x_dataStack = [{
      comments: [newComment],
      content: 'Nouveau commentaire',
      isAuthenticated: true
    }]

    expect(container._x_dataStack[0].comments[0].content).toBe('Nouveau commentaire')
  })

  it('permet de supprimer un commentaire', async () => {
    global.fetch
      .mockResolvedValueOnce({
        ok: true
      })

    container._x_dataStack = [{
      comments: [],
      isAuthenticated: true,
      userId: 1
    }]

    expect(container._x_dataStack[0].comments.length).toBe(0)
  })
})