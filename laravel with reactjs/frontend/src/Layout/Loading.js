const Loading = () => {
  return <>
      <div
          className="position-fixed top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center"
          style={{
              background: "rgba(0, 0, 0, 0.5)", // Màu nền mờ
              zIndex: 1050, // Đảm bảo nó che phủ tất cả
          }}
      >
          <div className="spinner-border text-light" role="status" style={{ width: "3rem", height: "3rem" }}>
              <span className="visually-hidden">Loading...</span>
          </div>
          <p
              className="text-light mt-3"
              style={{
                  fontSize: "1.25rem",
                  animation: "fadeInOut 1.5s infinite",
              }}
          >
              Loading data...
          </p>
          <style>
              {`
          @keyframes fadeInOut {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
          }
        `}
          </style>
      </div>
  </>
}

export default Loading;